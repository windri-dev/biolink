<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BioLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'type',
        'title',
        'subtitle',
        'url',
        'icon',
        'thumbnail_url',
        'card_size',
        'badge_text',
        'badge_color',
        'is_highlighted',
        'animation_type',
        'open_in_new_tab',
        'is_active',
        'sort_order',
        'total_clicks',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_highlighted' => 'boolean',
            'open_in_new_tab' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'total_clicks' => 'integer',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }

    /**
     * Increment click count atomically
     */
    public function recordClick(): void
    {
        $this->increment('total_clicks');
    }
}
