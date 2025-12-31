<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Verify Paystack signature
        $paystackSignature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        // if (!$paystackSignature || $paystackSignature !== hash_hmac('sha512', $payload, env('PAYSTACK_SECRET_KEY'))) {
        //     return response()->json(['status' => false, 'message' => 'Invalid signature'], 400);
        // }

        $data = json_decode($payload, true);

        // Log for debugging
        Log::info('Paystack Webhook:', $data);

        if (isset($data['event']) && $data['event'] === 'charge.success') {
            $amount    = $data['data']['amount'] / 100; // kobo → naira
            $reference = $data['data']['reference'] ?? null;
            $paidAt    = $data['data']['paid_at'] ?? null;
            $channel   = $data['data']['channel'] ?? null; // "dedicated_nuban" for virtual acct
            $email     = $data['data']['customer']['email'] ?? null;

            if ($channel === 'dedicated_nuban' && $email) {
                // Map payment to user by email
                $user = User::where('email', $email)->first();

                if ($user) {
                    // Prevent duplicate processing
                    if (!Payment::where('reference', $reference)->exists()) {

                        $loanBalance = $user->loan_balance;
                        $walletCredit = 0; // amount to credit into wallet
                        $loanPayment = 0;  // amount applied to loan
                    
                        if ($loanBalance > 0) {
                            // Deduct Outstanding Repayment first
                            if ($amount >= $loanBalance) {
                                // Full Outstanding Repayment, remaining goes to wallet
                                $loanPayment = $loanBalance;
                                $walletCredit = $amount - $loanBalance;
                    
                                // Reduce loan balance to zero
                                $user->loan_balance = 0;
                                $user->increment('wallet_balance', $walletCredit);
                            } else {
                                // Partial Outstanding Repayment, nothing left for wallet
                                $loanPayment = $amount;
                                $walletCredit = 0;
                    
                                // Reduce loan balance by the amount paid
                                $user->loan_balance = $loanBalance - $amount;
                            }
                    
                            $user->save();
                    
                            // Record Outstanding Repayment
                            DB::table('payments')->insert([
                                'user_id'    => $user->id,
                                'package'    => 'loan_repayment',
                                'reference'  => $reference,
                                'amount'     => $loanPayment,
                                'status'     => 'success',
                                'gateway'    => "paystack",
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                    
                            // If there’s leftover after Outstanding Repayment, record as wallet funding
                            if ($walletCredit > 0) {
                                DB::table('payments')->insert([
                                    'user_id'    => $user->id,
                                    'package'    => 'virtual_payment',
                                    'reference'  => $reference . '-wallet', // make unique reference
                                    'amount'     => $walletCredit,
                                    'status'     => 'success',
                                    'gateway'    => "paystack",
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } else {
                            // No loan, everything goes into wallet
                            $user->increment('wallet_balance', $amount);
                    
                            DB::table('payments')->insert([
                                'user_id'    => $user->id,
                                'package'    => 'virtual_payment',
                                'reference'  => $reference,
                                'amount'     => $amount,
                                'status'     => 'success',
                                'gateway'    => "paystack",
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                    
                }
            }
        }

        return response()->json(['status' => true]);
    }
}
