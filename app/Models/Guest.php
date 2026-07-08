<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'wedding_id',
        'name',
        'token',
        'passes_allocated',
        'passes_confirmed',
        'rsvp_status',
        'dietary_notes',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            $guest->token ??= Str::random(20);
        });
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function passesAvailable(): int
    {
        return max(0, $this->passes_allocated - $this->passes_confirmed);
    }
}
