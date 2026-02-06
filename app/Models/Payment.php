<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'account_name',
        'transaction_number',
        'proof_image',
        'status',
        'rejection_reason',
        'verified_at',
        'verified_by',
        'regular_hours_given',
        'vip_hours_given',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'expires_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function playSessions(): HasMany
    {
        return $this->hasMany(PlaySession::class);
    }

    /**
     * Check if payment is still active
     */
    public function isActive(): bool
    {
        return $this->status === 'approved' && $this->expires_at >= now();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}
