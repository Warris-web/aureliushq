<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public static function sendNotification($route = null, $type = 'info', $title = 'Notification', $message = '')
    {
        AuditHelper::log($type, $message);
        // Persist session until manually cleared
        session([
            'alert-type' => $type,
            'title' => $title,
            'message' => $message,
        ]);
    
        // Redirect as before
        if ($route) {
            return redirect()->route($route);
        }
    
        return redirect()->back();
    }
    
    
}
