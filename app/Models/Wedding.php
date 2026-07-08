<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wedding extends Model
{
    protected $fillable = [
        'groom_name',
        'bride_name',
        'wedding_date',
        'venue_name',
        'venue_address',
        'template',
        'config',
        'is_active',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function gallery(): array
    {
        return $this->config['gallery'] ?? [];
    }

    public function musicPath(): ?string
    {
        return $this->config['music'] ?? null;
    }

    public function loveStory(): ?string
    {
        return $this->config['love_story'] ?? null;
    }

    public function dressCode(): ?string
    {
        return $this->config['dress_code'] ?? null;
    }

    public function itinerary(): array
    {
        return $this->config['itinerary'] ?? [];
    }

    public function giftBankDetails(): ?string
    {
        return $this->config['gift_bank_details'] ?? null;
    }

    public function giftRegistryUrl(): ?string
    {
        return $this->config['gift_registry_url'] ?? null;
    }

    public function initials(): string
    {
        $groom = mb_substr(trim($this->groom_name), 0, 1);
        $bride = mb_substr(trim($this->bride_name), 0, 1);

        return mb_strtoupper($groom.' & '.$bride);
    }

    public function mapsUrl(): ?string
    {
        if (! $this->venue_address && ! $this->venue_name) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode($this->venue_name.' '.$this->venue_address);
    }

    public function mapsEmbedUrl(): ?string
    {
        if (! $this->venue_address && ! $this->venue_name) {
            return null;
        }

        // Direct embed endpoint (bypasses the /maps?...&output=embed redirect,
        // which carries X-Frame-Options: SAMEORIGIN and gets the iframe aborted).
        return 'https://www.google.com/maps/embed?origin=mfe&pb=!1m2!2m1!1s'.urlencode($this->venue_name.' '.$this->venue_address);
    }

    public function wazeUrl(): ?string
    {
        if (! $this->venue_address && ! $this->venue_name) {
            return null;
        }

        return 'https://waze.com/ul?q='.urlencode($this->venue_name.' '.$this->venue_address).'&navigate=yes';
    }
}
