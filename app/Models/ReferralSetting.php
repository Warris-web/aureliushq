<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_reward',
        'referred_reward',
        'commission_percentage'
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'referrer_reward' => 500,
            'referred_reward' => 200,
            'commission_percentage' => 3.00
        ]);
    }
}
