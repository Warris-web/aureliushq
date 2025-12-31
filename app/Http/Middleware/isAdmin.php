<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AuditHelper;
use App\Http\Controllers\GeneralController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();

        // If there is no logged-in user, just proceed
        if (!$user) {
            return $next($request);
        }

    if ($user->user_role !== 'admin' && $user->user_role != 'admin_manager') {

        return redirect()->route('dashboard');

        }

        if ($user && in_array($user->user_role, ['admin', 'admin_manager'])) {
            $action = strtoupper($request->method()) . ' ' . $request->path(); // e.g. GET admin/dashboard
            AuditHelper::log($action); // details will automatically include route path
        }
        return $next($request);
    }
}
