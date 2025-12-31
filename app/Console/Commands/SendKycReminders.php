<?php

namespace App\Console\Commands;

use App\Mail\KycReminderMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendKycReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kyc:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send KYC reminder emails to users who registered 24 hours ago and haven\'t completed KYC';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting KYC reminder process...');

        // Get users who registered approximately 24 hours ago (23-25 hours window)
        // and haven't completed KYC
        $startTime = Carbon::now()->subHours(25);
        $endTime = Carbon::now()->subHours(23);

        $users = User::whereBetween('created_at', [$startTime, $endTime])
            ->where(function($query) {
                $query->where('has_done_kyc', '!=', 'yes')
                      ->orWhereNull('has_done_kyc');
            })
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users found who need KYC reminders.');
            return 0;
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new KycReminderMail($user));
                $successCount++;
                $this->info("✓ Sent KYC reminder to: {$user->email}");

                Log::info("KYC reminder sent to user: {$user->id} - {$user->email}");
            } catch (\Exception $e) {
                $failCount++;
                $this->error("✗ Failed to send to: {$user->email}");
                Log::error("Failed to send KYC reminder to user {$user->id}: " . $e->getMessage());
            }
        }

        $this->info("\n=== KYC Reminder Summary ===");
        $this->info("Total users found: " . $users->count());
        $this->info("Successfully sent: {$successCount}");
        $this->info("Failed: {$failCount}");

        return 0;
    }
}
