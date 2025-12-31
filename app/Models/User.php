<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
{
    return $this->hasMany(Order::class);
}

public function cart()
{
    return $this->hasOne(Cart::class);
}


public function histories()
{
    return $this->hasMany(\App\Models\UserHistory::class, 'user_id');
}

public function referralsGiven()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referralReceived()
    {
        return $this->hasOne(Referral::class, 'referred_id');
    }



public function referrals()
{
    return $this->hasMany(Referral::class, 'referrer_id');
}

    // Scopes for level filtering
    public function scopeLow($query)
    {
        return $query->where('level', 'low');
    }

    public function scopeMid($query)
    {
        return $query->where('level', 'mid');
    }

    public function scopeHigh($query)
    {
        return $query->where('level', 'high');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

}
