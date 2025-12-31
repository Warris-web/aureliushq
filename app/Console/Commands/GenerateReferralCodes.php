<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Referral;

class GenerateReferralCodes extends Command
{
    protected $signature = 'referrals:generate';
    protected $description = 'Generate referral records and codes for users who do not have any.';

    public function handle()
    {
        $this->info('Generating referral records for existing users...');

        $users = User::whereDoesntHave('referralsGiven')->get();

        if ($users->isEmpty()) {
            $this->info('✅ All users already have referral records.');
            return;
        }

        foreach ($users as $user) {
            do {
                $code = strtoupper(substr(md5(uniqid($user->id, true)), 0, 8));
            } while (Referral::where('referral_code', $code)->exists());

            Referral::create([
                'referrer_id' => $user->id,
                'referral_code' => $code,
                'status' => 'active',
            ]);

            $this->line("Created referral for User ID {$user->id} with code {$code}");
        }

        $this->info('✅ Referral records generated successfully for all missing users.');
    }
}
