<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditHelper extends Controller
{
    public static function log($action, $details = null)
    {
        $user = Auth::user();
        $routePath = request()->path();

        $details = $details ?? $routePath;

        if ($user && in_array($user->user_role, ['admin', 'admin_manager'])) {
            AuditLog::create([
                'user_id'    => $user->id,
                'user_role'  => $user->user_role,
                'action'     => $action,
                'details'    => $details,
                'ip_address' => request()->ip(),
            ]);
        }
    }
}
