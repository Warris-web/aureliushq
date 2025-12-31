<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\LoanReminderController;


Route::post('/webhook/dojah', [PackageController::class, 'handleWebhook']);
Route::post('/kyc/webhook', [PackageController::class, 'handleWebhook']);
Route::get('/ping', function () {
    return response()->json([
        'message' => 'API is working 🚀',
    ]);
});



Route::get('/loan_payment_reminder', [LoanReminderController::class, 'sendReminders']);
Route::get('/auto-process-loans', [LoanReminderController::class, 'autoProcessLoanPayments']);

