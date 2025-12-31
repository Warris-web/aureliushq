<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Generate or return referral code for a user.
     */
    public function generateReferralCode($userId)
    {
        // Get or create referrer’s own code (one active per user)
        $ref = Referral::firstOrCreate(
            ['referrer_id' => $userId, 'referred_id' => null],
            ['referral_code' => strtoupper(Str::random(8)), 'status' => 'active']
        );

        return response()->json([
            'success' => true,
            'code' => $ref->referral_code,
            'link' => url('/register?ref=' . $ref->referral_code),
        ]);
    }

    /**
     * Validate and register referral when someone signs up using a referral code.
     */
    public static function registerReferral($referralCode, $newUserId = null, $validateOnly = false)
    {
        // Find active referral owner
        $referrerRecord = Referral::where('referral_code', $referralCode)
            ->whereNull('referred_id') // the referrer’s open slot
            ->first();

        // If no open slot found, get the latest referral for that code (means it's valid but fully used)
        if (!$referrerRecord) {
            $fallbackReferrer = Referral::where('referral_code', $referralCode)->first();
            if (!$fallbackReferrer) {
                return ['success' => false, 'message' => 'Invalid referral code'];
            }
            $referrerId = $fallbackReferrer->referrer_id;
        } else {
            $referrerId = $referrerRecord->referrer_id;
        }

        // Validate-only mode
        if ($validateOnly) {
            return [
                'success' => true,
                'message' => 'Referral code is valid',
                'referrer_id' => $referrerId
            ];
        }

        // Prevent self-referral
        if ($referrerId == $newUserId) {
            return ['success' => false, 'message' => 'You cannot use your own referral code'];
        }

        // Prevent duplicate referral for same user
        $alreadyReferred = Referral::where('referred_id', $newUserId)->exists();
        if ($alreadyReferred) {
            return ['success' => false, 'message' => 'You have already used a referral code'];
        }

        // Try to fill the open slot if available
        if ($referrerRecord && !$referrerRecord->referred_id) {
            $referrerRecord->update([
                'referred_id' => $newUserId,
                'status' => 'pending',
            ]);
        } else {
            // If no open slot found, create new referral record
            Referral::create([
                'referrer_id' => $referrerId,
                'referred_id' => $newUserId,
                'referral_code' => $referralCode,
                'status' => 'pending',
            ]);
        }

        // Ensure referred user has their own referral code for future
        Referral::firstOrCreate(
            ['referrer_id' => $newUserId, 'referred_id' => null],
            ['referral_code' => strtoupper(\Illuminate\Support\Str::random(8)), 'status' => 'active']
        );

        return ['success' => true, 'message' => 'Referral registered successfully'];
    }

    /**
     * Process referral reward after referred user completes their first order.
     */
    public static function completeReferral_old($referredUserId, $orderAmount = 0, $type = "activation")
    {
        $ref = Referral::where('referred_id', $referredUserId)
            ->first();

        if (!$ref) {
            return response()->json(['success' => false, 'message' => 'No valid referral found']);
        }

        if ($ref->reward_disbursed) {
            return response()->json(['success' => false, 'message' => 'Reward already credited']);
        }

        if ($type === 'activation') {
            $ref->update([
                'status' => 'completed'
            ]);
            return response()->json(['success' => true, 'message' => 'Account Activated']);

        }
        $settings = ReferralSetting::getSettings();
        $commission = ($orderAmount * ($settings->commission_percentage / 100));

        DB::transaction(function () use ($ref, $settings, $commission) {
            $referrer = User::find($ref->referrer_id);
            $referred = User::find($ref->referred_id);

            $ref->update([
                'status' => 'completed',
                'reward_amount' => $settings->referrer_reward,
                'commission' => $commission,
                'reward_disbursed' => true,
            ]);

            // Credit referrer
            $referrer->wallet_balance += $settings->referrer_reward;
            $referrer->save();

            UserHistory::create([
                'user_id' => $referrer->id,
                'message' => "You earned ₦{$settings->referrer_reward} for referring {$referred->name}.",
                'amount' => $settings->referrer_reward,
                'type' => 'referral_bonus'
            ]);

            // Credit referred user
            $referred->wallet_balance += $settings->referred_reward;
            $referred->save();

            UserHistory::create([
                'user_id' => $referred->id,
                'message' => "You received ₦{$settings->referred_reward} as a welcome bonus for joining via referral.",
                'amount' => $settings->referred_reward,
                'type' => 'welcome_bonus'
            ]);

            // Milestone Bonuses
            // $count = Referral::where('referrer_id', $referrer->id)
            //     ->where('status', 'completed')
            //     ->count();

            // if ($count % 100 === 0) {
            //     $referrer->wallet_balance += 50000;
            //     $referrer->save();

            //     UserHistory::create([
            //         'user_id' => $referrer->id,
            //         'message' => "Milestone reward: ₦50,000 bonus for 100 successful referrals!",
            //         'amount' => 50000,
            //         'type' => 'milestone_bonus'
            //     ]);
            // } elseif ($count % 10 === 0) {
            //     $referrer->wallet_balance += 5000;
            //     $referrer->save();

            //     UserHistory::create([
            //         'user_id' => $referrer->id,
            //         'message' => "Milestone reward: ₦5,000 bonus for 10 successful referrals!",
            //         'amount' => 5000,
            //         'type' => 'milestone_bonus'
            //     ]);
            // }
        });

        return response()->json(['success' => true, 'message' => 'Referral reward successfully processed']);
    }

    public static function completeReferral($referredUserId, $orderAmount = 0, $type = "activation")
{
    $ref = Referral::where('referred_id', $referredUserId)->first();

    if (!$ref) {
        return response()->json([
            'success' => false,
            'message' => 'No valid referral found'
        ]);
    }

    // ACTIVATION FLOW
    if ($type === 'activation') {

        if ($ref->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Referral already completed'
            ]);
        }

        $ref->update([
            'status' => 'completed'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Account Activated'
        ]);
    }

    // ORDER-BASED FLOW
    if ($ref->reward_disbursed) {
        return response()->json([
            'success' => false,
            'message' => 'Reward already credited'
        ]);
    }

    $settings = ReferralSetting::getSettings();
    $referrerReward = $settings->referrer_reward ?? 0;
    $referredReward = $settings->referred_reward ?? 0;
    $commissionPercentage = $settings->commission_percentage ?? 0;

    $commission = ($orderAmount * ($commissionPercentage / 100));

    // Safe transaction
    DB::transaction(function () use ($ref, $referrerReward, $referredReward, $commission) {

        $referrer = User::find($ref->referrer_id);
        $referred = User::find($ref->referred_id);

        // SAFETY CHECK (NO EXCEPTION)
        if (!$referrer || !$referred) {
            // simply stop processing silently
            return;
        }

        // Update referral record
        $ref->update([
            'status' => 'completed',
            'reward_amount' => $referrerReward,
            'commission' => $commission,
            'reward_disbursed' => true,
        ]);

        // CREDIT REFERRER
        $referrer->wallet_balance += $referrerReward;
        $referrer->save();

        UserHistory::create([
            'user_id' => $referrer->id,
            'message' => "You earned ₦{$referrerReward} for referring {$referred->name}.",
            'amount' => $referrerReward,
            'type' => 'referral_bonus'
        ]);

        // CREDIT REFERRED USER
        $referred->wallet_balance += $referredReward;
        $referred->save();

        UserHistory::create([
            'user_id' => $referred->id,
            'message' => "You received ₦{$referredReward} as a welcome bonus.",
            'amount' => $referredReward,
            'type' => 'welcome_bonus'
        ]);
    });

    return response()->json([
        'success' => true,
        'message' => 'Referral reward successfully processed'
    ]);
}


    /**
     * Get referral leaderboard.
     */
    public function leaderboard()
    {
        $leaders = Referral::select('referrer_id', DB::raw('count(*) as total'))
            ->where('status', 'completed')
            ->groupBy('referrer_id')
            ->orderByDesc('total')
            ->with('referrer:id,name,email,wallet_balance')
            ->take(10)
            ->get();

        return response()->json(['success' => true, 'leaders' => $leaders]);
    }

    /**
     * Get logged-in user’s earnings history.
     */
    public function myEarningHistory(Request $request)
    {
        $user = $request->user();

        $history = $user->histories()
            ->latest()
            ->get(['type', 'amount', 'message', 'created_at']);

        return response()->json([
            'success' => true,
            'wallet_balance' => $user->wallet_balance,
            'history' => $history,
        ]);
    }


    public function referralPage(Request $request)
    {
        $user = $request->user();

        $refRecord = Referral::firstOrCreate(
            ['referrer_id' => $user->id, 'referred_id' => null],
            ['referral_code' => strtoupper(\Illuminate\Support\Str::random(8)), 'status' => 'active']
        );

        $referralCode = $refRecord->referral_code;
        $referralLink = url('/register?ref=' . $referralCode);

        $myReferrals = Referral::with('referred:id,first_name,last_name,email,created_at')
            ->where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->latest()
            ->get();

        // Earnings history
        $history = $user->histories()
            ->whereIn('type', ['referral_bonus', 'welcome_bonus', 'milestone_bonus'])
            ->latest()
            ->get();

        // Leaderboard: fetch top users by completed referrals (user-centric)
        $leaders = User::select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.wallet_balance')
            ->withCount(['referrals as total' => function ($q) {
                $q->whereNotNull('referred_id')
                  ->where('status', 'completed');
            }])
            ->having('total', '>', 0)
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // Referral counts
        $totalInvites = Referral::where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->count();

        $completedInvites = Referral::where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->where('status', 'completed')
            ->count();

        $pendingInvites = Referral::where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->where('status', 'pending')
            ->count();

        $res_info = ReferralSetting::first();
        $how_it_works = $res_info->how_it_works ?? "Not Set";

        return view('user_new.referral', compact(
            'referralCode',
            'referralLink',
            'myReferrals',
            'history',
            'leaders',
            'how_it_works',
            'res_info',
            'totalInvites',
            'completedInvites',
            'pendingInvites'
        ));
    }



    /**
     * Get list of users I referred.
     */
    public function myReferrals(Request $request)
    {
        $user = $request->user();

        $myReferrals = Referral::where('referrer_id', $user->id)
            ->whereNotNull('referred_id')
            ->with('referred:id,name,email')
            ->latest()
            ->get(['id', 'referred_id', 'status', 'reward_amount', 'created_at']);

        return response()->json([
            'success' => true,
            'referrals' => $myReferrals,
        ]);
    }



    public function settings()
    {
        $settings = DB::table('referral_settings')->first();
        return view('admin.referral_settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'referrer_reward' => 'required|numeric|min:0',
            'referred_reward' => 'required|numeric|min:0',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'display_referral_note' => 'required|in:yes,no',
        ]);

        DB::table('referral_settings')->update([
            'referrer_reward' => $request->referrer_reward,
            'referred_reward' => $request->referred_reward,
            'commission_percentage' => $request->commission_percentage,
            'referral_note' => $request->referral_note,
            'how_it_works' => $request->how_it_works,
            'term_of_use' => $request->term_of_use,
            'display_referral_note' => $request->display_referral_note,
            'updated_at' => now(),
        ]);

        return GeneralController::sendNotification('', 'success', '', 'Referral settings updated successfully.');
    }


    public function admin_history()
    {
        $histories = DB::table('user_histories')
            ->join('users', 'user_histories.user_id', '=', 'users.id')
            ->select('user_histories.*', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('user_histories.created_at', 'desc')
            ->get();

        return view('admin.user_history', compact('histories'));
    }

    public function referralLeaderboard()
    {
        $leaderboard = DB::table('referrals')
            ->join('users', 'referrals.referrer_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.email',
                DB::raw('COUNT(referrals.id) as total_referrals'),
                DB::raw('SUM(referrals.reward_amount) as total_reward')
            )
            ->whereNotNull('referrals.referred_id')
            ->where('referrals.status', 'completed')
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.email')
            ->having('total_referrals', '>', 0)
            ->orderByDesc('total_referrals')
            ->get();

        return view('admin.referral_leaderboard', compact('leaderboard'));
    }
}
