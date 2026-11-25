<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Dark Luxury (Default)',
                'slug' => 'dark-luxury',
                'background_type' => 'gradient',
                'background_value' => 'radial-gradient(circle at 50% 0%, #1e1e24 0%, #0d0d11 100%)',
                'card_bg' => 'rgba(255, 255, 255, 0.05)',
                'card_border' => 'rgba(255, 255, 255, 0.12)',
                'card_text' => '#f3f4f6',
                'card_hover_bg' => 'rgba(255, 255, 255, 0.12)',
                'text_color' => '#ffffff',
                'subtext_color' => '#9ca3af',
                'accent_color' => '#38bdf8',
                'font_family' => 'Plus Jakarta Sans, sans-serif',
                'button_shape' => 'rounded-2xl',
                'is_dark' => true,
                'is_preset' => true,
            ],
            [
                'name' => 'Midnight Indigo',
                'slug' => 'midnight-indigo',
                'background_type' => 'gradient',
                'background_value' => 'linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%)',
                'card_bg' => 'rgba(30, 41, 59, 0.65)',
                'card_border' => 'rgba(99, 102, 241, 0.25)',
                'card_text' => '#ffffff',
                'card_hover_bg' => 'rgba(99, 102, 241, 0.2)',
                'text_color' => '#ffffff',
                'subtext_color' => '#a5b4fc',
                'accent_color' => '#818cf8',
                'font_family' => 'Inter, sans-serif',
                'button_shape' => 'rounded-2xl',
                'is_dark' => true,
                'is_preset' => true,
            ],
            [
                'name' => 'Emerald Glass',
                'slug' => 'emerald-glass',
                'background_type' => 'gradient',
                'background_value' => 'linear-gradient(180deg, #064e3b 0%, #022c22 100%)',
                'card_bg' => 'rgba(6, 78, 59, 0.35)',
                'card_border' => 'rgba(52, 211, 153, 0.25)',
                'card_text' => '#ecfdf5',
                'card_hover_bg' => 'rgba(52, 211, 153, 0.2)',
                'text_color' => '#ffffff',
                'subtext_color' => '#6ee7b7',
                'accent_color' => '#10b981',
                'font_family' => 'Plus Jakarta Sans, sans-serif',
                'button_shape' => 'rounded-full',
                'is_dark' => true,
                'is_preset' => true,
            ],
            [
                'name' => 'Minimalist Cream',
                'slug' => 'minimalist-cream',
                'background_type' => 'solid',
                'background_value' => '#FBF9F5',
                'card_bg' => '#FFFFFF',
                'card_border' => '#E5E0D8',
                'card_text' => '#18181b',
                'card_hover_bg' => '#F4EFE6',
                'text_color' => '#18181b',
                'subtext_color' => '#71717a',
                'accent_color' => '#a18a68',
                'font_family' => 'Outfit, sans-serif',
                'button_shape' => 'rounded-xl',
                'is_dark' => false,
                'is_preset' => true,
            ],
            [
                'name' => 'Cyberpunk Neon',
                'slug' => 'cyberpunk-neon',
                'background_type' => 'gradient',
                'background_value' => 'linear-gradient(135deg, #050505 0%, #170529 100%)',
                'card_bg' => 'rgba(255, 0, 128, 0.08)',
                'card_border' => 'rgba(0, 240, 255, 0.4)',
                'card_text' => '#00f0ff',
                'card_hover_bg' => 'rgba(0, 240, 255, 0.15)',
                'text_color' => '#ffffff',
                'subtext_color' => '#f43f5e',
                'accent_color' => '#00f0ff',
                'font_family' => 'DM Mono, monospace',
                'button_shape' => 'rounded-lg',
                'is_dark' => true,
                'is_preset' => true,
            ],
            [
                'name' => 'Sunset Aura',
                'slug' => 'sunset-aura',
                'background_type' => 'gradient',
                'background_value' => 'linear-gradient(135deg, #4c0519 0%, #1e1b4b 100%)',
                'card_bg' => 'rgba(255, 255, 255, 0.08)',
                'card_border' => 'rgba(244, 63, 94, 0.3)',
                'card_text' => '#ffffff',
                'card_hover_bg' => 'rgba(244, 63, 94, 0.2)',
                'text_color' => '#ffffff',
                'subtext_color' => '#fda4af',
                'accent_color' => '#fb7185',
                'font_family' => 'Plus Jakarta Sans, sans-serif',
                'button_shape' => 'rounded-2xl',
                'is_dark' => true,
                'is_preset' => true,
            ],
        ];

        foreach ($themes as $themeData) {
            Theme::updateOrCreate(['slug' => $themeData['slug']], $themeData);
        }
    }
}
