<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule KYC reminder emails as a cron job
// Runs every hour to check for users who registered 24 hours ago
Schedule::command('kyc:send-reminders')
    ->cron('0 * * * *')  // Runs at the start of every hour
    ->withoutOverlapping()
    ->runInBackground();
