<?php 

use App\Models\Food;
use App\Models\KycLevel;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;






if (!function_exists('has_paid_onboarding')) {
    function has_paid_onboarding($user_id) {
        $info = User::where('id', $user_id)->first();
        if(!$info){
            return false;
        }
        if($info->has_paid_onboarding ==='no'){
            return false;
        }
        return true;
    }
}
if (!function_exists('has_done_kyc')) {
    function has_done_kyc($user_id) {
        $info = User::where('id', $user_id)->first();
        if(!$info){
            return false;
        }
        if($info->has_done_kyc ==='no'){
            return false;
        }
        return true;
    }
}

// app/Helpers/CustomHelper.php

// app/Helpers/CustomHelper.php
if (!function_exists('kyc_levels')) {
    function kyc_levels() {
        return KycLevel::all()->mapWithKeys(function ($level) {
            return [
                $level->key => [
                    'title' => $level->title,
                    'description' => $level->description,
                    'endpoint' => route('kyc.process', ['level' => $level->key]),
                ]
            ];
        })->toArray();
    }
}


if (!function_exists('get_product_image')) {
    function get_product_image($name) {
        $food_info = Food::where('name', trim($name))->first();

        if ($food_info && !is_null($food_info->image)) {
            return $food_info->image;
        } else {
            return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuCZtWNJjBjxoVw9OCxZXKQE-biHdtZ7c5Ig&s';
        }
    }
}


if (!function_exists('platform_settings')) {
    function platform_settings($key = null)
    {
        // Cache the settings to avoid multiple DB calls
        static $settings = null;

        if ($settings === null) {
            $settings = DB::table('platform_settings')->first();
        }

        if (!$settings) {
            return null;
        }

        if ($key) {
            return $settings->$key ?? null;
        }

        return $settings; // Return full object if no key provided
    }
}
if (!function_exists('user_notifications')) {
    function user_notifications($type = null)
    {
        static $data = null;

        if ($data === null) {
            $user = Auth::user();
            $query = Notification::query();

            if ($user && $user->created_at) {
                $query->where('created_at', '>=', $user->created_at);
            }

            $notifications = $query->orderBy('created_at', 'desc')->get();
            $readIds = json_decode(request()->cookie('notif_read')) ?? [];
            $unreadCount = $notifications->whereNotIn('id', $readIds)->count();

            $data = [
                'notifications' => $notifications,
                'unreadCount'   => $unreadCount,
                'readIds'       => $readIds,
            ];
        }

        return $type ? ($data[$type] ?? null) : $data;
    }
}


if (!function_exists('has_permission')) {
   
    function has_permission(string $permission): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }
        $permissions = is_array($user->permissions)
            ? $user->permissions
            : json_decode($user->permissions, true);

        if (empty($permissions)) {
            return false;
        }

        return in_array($permission, $permissions);
    }
}
?>