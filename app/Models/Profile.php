<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'theme_id',
        'handle',
        'display_name',
        'avatar_url',
        'bio',
        'tagline',
        'location',
        'phone',
        'job_title',
        'company',
        'enable_vcard',
        'enable_bento_grid',
        'is_verified',
        'verified_title',
        'badge_style',
        'show_share_button',
        'show_subscribe_box',
        'ai_assistant_enabled',
        'ai_assistant_name',
        'ai_avatar_url',
        'ai_greeting_message',
        'ai_provider',
        'ai_api_key',
        'ai_api_base',
        'ai_model',
        'ai_system_prompt',
        'ai_temperature',
        'ai_rate_limit_per_minute',
        'ai_rate_limit_per_hour',
        'ai_security_guard',
        'ai_content_filter',
        'ai_block_duration_minutes',
        'meta_title',
        'meta_description',
        'custom_css',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'enable_vcard' => 'boolean',
            'enable_bento_grid' => 'boolean',
            'show_share_button' => 'boolean',
            'show_subscribe_box' => 'boolean',
            'ai_assistant_enabled' => 'boolean',
            'ai_security_guard' => 'boolean',
            'ai_content_filter' => 'boolean',
            'ai_rate_limit_per_minute' => 'integer',
            'ai_rate_limit_per_hour' => 'integer',
            'ai_block_duration_minutes' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->orderBy('sort_order');
    }

    public function activeSocialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function bioLinks(): HasMany
    {
        return $this->hasMany(BioLink::class)->orderBy('sort_order');
    }

    public function activeBioLinks(): HasMany
    {
        return $this->hasMany(BioLink::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function aiKnowledges(): HasMany
    {
        return $this->hasMany(AiKnowledge::class)->orderBy('sort_order');
    }

    public function activeAiKnowledges(): HasMany
    {
        return $this->hasMany(AiKnowledge::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }

    /**
     * Get clean handle without leading @
     */
    public function getCleanHandleAttribute(): string
    {
        return ltrim($this->handle, '@');
    }
}
