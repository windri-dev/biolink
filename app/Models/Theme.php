<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'background_type',
        'background_value',
        'card_bg',
        'card_border',
        'card_text',
        'card_hover_bg',
        'text_color',
        'subtext_color',
        'accent_color',
        'font_family',
        'button_shape',
        'is_dark',
        'is_preset',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_dark' => 'boolean',
            'is_preset' => 'boolean',
        ];
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
