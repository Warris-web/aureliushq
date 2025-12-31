<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    
    /**
     * Mark the authenticated user's email address as verified.
     */
    /**
 * @group Authentication
 * Verify email
 *
 * Marks the user's email as verified.
 *
 * @urlParam id int required User ID
 * @urlParam hash string required Verification hash
 *
 * @response 200 {
 *  "success": true,
 *  "message": "Email verified successfully"
 * }
 */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
