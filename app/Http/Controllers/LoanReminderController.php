<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class LoanReminderController extends Controller
{
    public function sendReminders()
{
    $today = \Carbon\Carbon::today();
    $datesToRemind = [
        $today->copy()->addDays(2)->toDateString(),
        $today->copy()->addDay()->toDateString(),
        $today->toDateString(),
    ];

    $repayments = DB::table('loan_repayments')
        ->where('status', 'pending')
        ->whereIn('due_date', $datesToRemind)
        ->get();

    if ($repayments->isEmpty()) {
        return response()->json(['message' => 'No pending repayments due soon.']);
    }

    foreach ($repayments as $repayment) {
        $user = DB::table('users')->where('id', $repayment->user_id)->first();

        if (!$user) continue;

        $dueDate = \Carbon\Carbon::parse($repayment->due_date)->format('l, F j, Y');
        $subject = "Outstanding Payment Reminder – Due {$dueDate}";
        $body = "
            Dear {$user->first_name} {$user->last_name},<br><br>
            This is a friendly reminder that your Outstanding repayment of 
            <strong>₦" . number_format($repayment->repayment_amount, 2) . "</strong> 
            is due on <strong>{$dueDate}</strong>.<br><br>
            Kindly ensure payment is made promptly to avoid penalties.<br><br>
            Thank you.<br>
            <strong>Aurelius Team</strong>
        ";

        $recipients = [$user->email];
        if (!empty($user->alt_email)) {
            $recipients[] = $user->alt_email;
        }

        foreach ($recipients as $email) {
            Mail::send([], [], function ($message) use ($email, $subject, $body) {
                $message->to($email)
                        ->subject($subject)
                        ->html($body);
            });
        }
    }

    return response()->json(['message' => 'Loan reminders sent successfully ✅']);
}

public function autoProcessLoanPayments()
    {
        try {
            $today = Carbon::today();

            // Fetch all pending loans whose due_date <= today
            $loans = DB::table('loan_repayments')
                ->where('status', 'pending')
                ->whereDate('due_date', '<=', $today)
                ->get();

            foreach ($loans as $loan) {
                $user = DB::table('users')
                    ->where('id', $loan->user_id)
                    ->lockForUpdate()
                    ->first();

                if (!$user) {
                    continue;
                }

                DB::beginTransaction();

                $amount = $loan->repayment_amount;
                $primaryEmail = $user->email;
                $altEmail = $user->alt_email;

                // Check wallet balance
                if ($user->wallet_balance >= $amount) {
                    // Deduct wallet + loan balance
                    $newWalletBalance = $user->wallet_balance - $amount;
                    $newLoanBalance = $user->loan_balance - $amount;

                    DB::table('users')->where('id', $user->id)->update([
                        'wallet_balance' => $newWalletBalance,
                        'loan_balance' => $newLoanBalance,
                        'updated_at' => now(),
                    ]);

                    // Mark repayment as paid
                    DB::table('loan_repayments')->where('id', $loan->id)->update([
                        'status' => 'paid',
                        'updated_at' => now(),
                    ]);

                    // Log into payments table
                    DB::table('payments')->insert([
                        'user_id' => $user->id,
                        'package' => 'Outstanding Repayment',
                        'gateway' => 'Wallet',
                        'reference' => 'Outstanding-' . strtoupper(uniqid()),
                        'amount' => $amount,
                        'status' => 'success',
                        'response' => json_encode([
                            'message' => 'Outstanding Repayment auto-processed successfully',
                            'loan_id' => $loan->id,
                            'wallet_balance_after' => $newWalletBalance,
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::commit();

                    // Email message (success)
                    $html = "
                        <h2>Hello {$user->first_name} {$user->last_name},</h2>
                        <p>Your Outstanding Repayment of <strong>₦" . number_format($amount, 2) . "</strong> has been successfully processed.</p>
                        <p>Your new wallet balance is <strong>₦" . number_format($newWalletBalance, 2) . "</strong>.</p>
                        <p>Thank you for staying consistent with your payments.</p>
                    ";

                    // Send to both emails if available
                    $this->sendEmail([$primaryEmail, $altEmail], "Outstanding Payment Successful", $html);

                } else {
                    DB::rollBack();

                    // Log failed attempt
                    DB::table('payments')->insert([
                        'user_id' => $user->id,
                        'package' => 'Outstanding Repayment',
                        'gateway' => 'Wallet',
                        'reference' => 'Outstanding-' . strtoupper(uniqid()),
                        'amount' => $amount,
                        'status' => 'failed',
                        'response' => json_encode([
                            'message' => 'Insufficient wallet balance for repayment',
                            'loan_id' => $loan->id,
                            'wallet_balance' => $user->wallet_balance,
                        ]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Email message (failure)
                    $html = "
                        <h2>Hello {$user->first_name} {$user->last_name},</h2>
                        <p>Your scheduled Outstanding repayment of <strong>₦" . number_format($amount, 2) . "</strong> could not be processed because your wallet balance is insufficient.</p>
                        <p>Please fund your wallet immediately to avoid default penalties.</p>
                    ";

                    // Send to both emails if available
                    $this->sendEmail([$primaryEmail, $altEmail], "Outstanding Payment Failed - Insufficient Balance", $html);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Loan payments processed successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Send embedded HTML email directly
     */
    public function sendEmail($to, $subject, $htmlContent)
    {
        // Filter null or empty emails
        $recipients = array_filter((array)$to);

        if (empty($recipients)) {
            return;
        }

        Mail::send([], [], function ($message) use ($recipients, $subject, $htmlContent) {
            $message->to($recipients)
                    ->subject($subject)
                    ->html($htmlContent);
        });
    }


}