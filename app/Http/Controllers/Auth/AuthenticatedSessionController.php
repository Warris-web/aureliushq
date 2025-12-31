<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{

    
    /**
     * Display the login view.
     */
    /**
 * @group Authentication
 * Login a user
 *
 * Logs in a user and returns a JSON token.
 *
 * @bodyParam email string required The user's email.
 * @bodyParam password string required The user's password.
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
 */
    public function create(): View
    {
        return view('auth_new.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    /**
 * @group Authentication
 * Login a user
 *
 * Logs in a user and returns a JSON token.
 *
 * @bodyParam email string required The user's email.
 * @bodyParam password string required The user's password.
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
 */

public function store(LoginRequest $request): RedirectResponse
{
    // Authenticate user (this will check credentials)
    $request->authenticate();

    // Check if inactive **before** session regenerate, so we can redirect back with errors
    if (Auth::user()->account_status === 'inactive' &&   Auth::user()->user_role != 'admin') {
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => ['Account Suspended/Blocked — Kindly reach out to Admin.'],
        ]);
    }

    // Now safe to regenerate session
    $request->session()->regenerate();

    // Redirect for active users
    return redirect()->route('check_login');
}


    /**
     * Destroy an authenticated session.
     */

    /**
 * @group Authentication
 * Logout a user
 *
 * Logs out the authenticated user.
 *
 * @response 200 {
 *  "success": true,
 *  "message": "Logged out successfully"
 * }
 */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
