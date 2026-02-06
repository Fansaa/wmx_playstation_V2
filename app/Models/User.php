<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'instagram',
        'referral_code',
        'own_referral_code',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User's payments
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * User's coupons
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * User's play sessions
     */
    public function playSessions(): HasMany
    {
        return $this->hasMany(PlaySession::class);
    }

    /**
     * Get users who used this user's referral code
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referral_code', 'own_referral_code');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Generate unique referral code for new user
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = 'WMX-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (self::where('own_referral_code', $code)->exists());
        
        return $code;
    }

    /**
     * Get total remaining quota hours
     */
    public function getRemainingQuota(): array
    {
        $approvedPayments = $this->payments()
            ->where('status', 'approved')
            ->where('expires_at', '>=', now())
            ->get();

        $usedSessions = $this->playSessions()
            ->whereIn('status', ['confirmed', 'completed'])
            ->get();

        $totalRegular = $approvedPayments->sum('regular_hours_given');
        $totalVip = $approvedPayments->sum('vip_hours_given');

        $usedRegular = $usedSessions->where('type', 'regular')->sum('duration_hours');
        $usedVip = $usedSessions->where('type', 'vip')->sum('duration_hours');

        return [
            'regular' => max(0, $totalRegular - $usedRegular),
            'vip' => max(0, $totalVip - $usedVip),
        ];
    }
}
