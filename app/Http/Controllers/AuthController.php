<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    /**
 * @group Authentication
 * Login a user
 *
 * Logs in a user and returns an API token.
 *
 * @bodyParam email string required The user's email. Example: user@example.com
 * @bodyParam password string required The user's password. Example: secret123
 *
 * @response 200 {
 *  "success": true,
 *  "token": "abcdef123456",
 *  "user": {
 *      "id": 1,
 *      "name": "John Doe",
 *      "email": "user@example.com"
 *  }
 * }
 *
 * @response 401 {
 *  "success": false,
 *  "message": "Invalid credentials"
 * }
 */
public function login(Request $request)
{
    // your existing login logic
}

    public function showVerifyForm()
    {
        return view('auth_new.email_verification');
    }


    public function verify(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required',
            ]);

            $email = Auth::user()->email;
            $enteredOtp = $request->otp;

            // Check if OTP exists and matches
            $storedOtp = Cache::get('otp_' . $email);

            if ($storedOtp == $enteredOtp) {
                // Clear the OTP from cache
                Cache::forget('otp_' . $email);

                // Update user verification status
                $user = User::findOrFail(Auth::user()->id);
                $user->update(['has_verified_email' => 'yes']);

                // Send welcome email (non-blocking best-effort)
                try {
                    Mail::to($user->email)->send(new WelcomeMail($user));
                } catch (\Throwable $e) {
                    // swallow mail errors to not block verification response
                }

                return response()->json(['message' => 'OTP verified successfully!', 'status'=> true]);

                // return redirect()->route('check_login')->with('success', 'OTP verified successfully!');
            }


            return response()->json(['message' => 'Invalid OTP. Please try again.', 'status'=> false], 400);

            // return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            
            return response()->json(['message' => 'Please enter all 6 digits of the OTP.', 'status'=> false], 422);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Something went wrong. Please try again.', 'status'=> false], 500);

        }
    }

    public function resend(Request $request)
    {
        try {
            $user = Auth::user();
            $email = $user->email;

            // Generate new OTP
            $otp = rand(100000, 999999);

            // Store OTP in cache with 10 minutes expiry
            Cache::put('otp_' . $email, $otp, now()->addMinutes(10));

            // Send email
            Mail::raw("Your new OTP code is: {$otp}\n\nIt expires in 10 minutes.\n\nIf you didn't request this, please ignore this email.", function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your New Aurelius OTP Code')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            // Log for debugging (remove in production)


            return response()->json([
                'message' => 'A new OTP has been sent to your email.',
                'success' => true
            ]);
            // return back()->with('status', 'A new OTP has been sent to your email.');

        } catch (\Exception $e) {


            return response()->json([
                'messsage' => 'Failed to send OTP. Please try again. ' . $e->getMessage(),
                'success' => false
            ], 500);

            // return back()->with('error', 'Failed to send OTP. Please try again.');
        }
    }


    public function check_login()
    {
        if (Auth::id()) {
            if (Auth::user()->user_role === 'admin' || Auth::user()->user_role ==='admin_manager') {
                return redirect()->route('admin.dashboard');
            }
            
            if (Auth::user()->has_verified_email == 'no') {
                return redirect()->route('otp.verify');
            } elseif (Auth::user()->has_paid_onboarding == 'yes') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->back();
        }
    }
}
