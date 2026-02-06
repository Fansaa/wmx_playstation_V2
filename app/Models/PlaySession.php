<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlaySession extends Model
{
    protected $fillable = [
        'user_id',
        'payment_id',
        'branch',
        'type',
        'duration_hours',
        'status',
        'played_at',
        'confirmed_by',
    ];

    protected function casts(): array
    {
        return [
            'played_at' => 'datetime',
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

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Get branch list
     */
    public static function getBranches(): array
    {
        return ['Serang', 'Semarang', 'Palembang', 'Purwodadi'];
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }
}
