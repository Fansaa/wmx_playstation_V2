<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'code',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Generate unique coupon code
     */
    public static function generateCode(): string
    {
        do {
            $code = 'WMX-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'used' => 'blue',
            'expired' => 'gray',
            default => 'gray',
        };
    }
}
