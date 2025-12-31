<?php

namespace App\Http\Middleware;

use App\Http\Controllers\GeneralController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKycOnboarding
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Get the authenticated user
        $user = $request->user();

        // If there is no logged-in user, just proceed
        if (!$user) {
            return $next($request);
        }

        // ✅ Check if the user has not completed KYC
        if ($user->has_done_kyc === 'no') {
            // return GeneralController::sendNotification(
            //     'onboarding_page',
            //     'error',
            //     'KYC Verification Required',
            //     'You must complete your KYC verification before you can access the next section.'
            // );
            return response()->view('user_new.inline_redirect', [
                'message' => 'Please complete your KYC before proceeding. Redirecting in 5 seconds...',
                'redirect_url' => route('dashboard'),
            ]);
        }

        // ✅ Check if the user has not paid onboarding
        if ($user->has_paid_onboarding === 'no') {
            // return GeneralController::sendNotification(
            //     'onboarding_page',
            //     'error',
            //     'Onboarding Payment Required',
            //     'You must complete your onboarding payment before you can access the next section.'
            //     // 'You must complete your onboarding payment before you can access this section.'
            // );
            return response()->view('user_new.inline_redirect', [
                'message' => 'Please complete onboarding payment first. Redirecting in 5 seconds...',
                'redirect_url' => route('dashboard'),
            ]);
        }

        // ✅ If both checks pass, allow request to continue
        return $next($request);
    }
}
