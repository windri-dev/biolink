<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BioLink;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $theme = Theme::where('slug', 'dark-luxury')->first();

        $profile = Profile::updateOrCreate(
            ['handle' => 'windri'],
            [
                'user_id' => $user->id,
                'theme_id' => $theme?->id,
                'display_name' => 'Windri',
                'avatar_url' => 'https://avatars.githubusercontent.com/u/102558837?v=4',
                'bio' => 'Senior Full-Stack Software Engineer & Builder. Focusing on distributed systems, AI agent workflows, and clean web engineering.',
                'tagline' => 'Full-Stack Software Engineer',
                'location' => 'Jakarta, Indonesia',
                'phone' => '+628123456789',
                'job_title' => 'Senior Full-Stack Engineer',
                'company' => 'windri-dev',
                'enable_vcard' => true,
                'enable_bento_grid' => true,
                'is_verified' => true,
                'verified_title' => 'Verified Engineer',
                'badge_style' => 'blue',
                'show_share_button' => true,
                'ai_assistant_enabled' => true,
                'ai_assistant_name' => 'Aura',
                'ai_greeting_message' => 'Halo! Saya asisten AI Windri. Tanyakan apa saja tentang proyek, stack teknologi, atau kontak kolaborasi! ✨',
                'meta_title' => 'Windri (@windri) • Bio.link Official',
                'meta_description' => 'Hub profil resmi Windri. Temukan repositori GitHub, proyek aplikasi e-commerce SHOPPE, arsitektur server, dan kontak.',
            ]
        );

        // Social Links
        $socials = [
            ['platform' => 'github', 'url' => 'https://github.com/windri-dev', 'label' => 'GitHub', 'sort_order' => 1],
            ['platform' => 'telegram', 'url' => 'https://t.me/windri', 'label' => 'Telegram', 'sort_order' => 2],
            ['platform' => 'email', 'url' => 'mailto:mail262@gmail.com', 'label' => 'Email', 'sort_order' => 3],
            ['platform' => 'website', 'url' => 'https://wn-cdn.net', 'label' => 'Website', 'sort_order' => 4],
        ];

        foreach ($socials as $soc) {
            SocialLink::updateOrCreate(
                ['profile_id' => $profile->id, 'platform' => $soc['platform']],
                [...$soc, 'is_active' => true]
            );
        }

        // Bio Links (Demonstrating Full Width & Modular Bento Grid Cards)
        $links = [
            [
                'type' => 'link',
                'title' => 'GitHub windri-dev',
                'subtitle' => 'Jelajahi repositori open-source & proyek aktif',
                'url' => 'https://github.com/windri-dev',
                'icon' => 'github',
                'card_size' => 'full',
                'badge_text' => 'OFFICIAL',
                'badge_color' => 'sky',
                'is_highlighted' => true,
                'animation_type' => 'pulse',
                'sort_order' => 1,
            ],
            [
                'type' => 'link',
                'title' => 'SHOPPE E-Commerce Staging',
                'subtitle' => 'Platform butik modern dengan AI Fashion Concierge',
                'url' => 'https://shoppe-staging.wn-cdn.net',
                'icon' => 'shopping-bag',
                'card_size' => 'full',
                'badge_text' => 'LIVE DEMO',
                'badge_color' => 'emerald',
                'is_highlighted' => false,
                'animation_type' => 'none',
                'sort_order' => 2,
            ],
            [
                'type' => 'link',
                'title' => 'Web HBD Project',
                'subtitle' => 'Aplikasi web interaktif ucapan spesial',
                'url' => 'https://hbd.wn-cdn.net',
                'icon' => 'sparkles',
                'card_size' => 'half',
                'badge_text' => 'CREATIVE',
                'badge_color' => 'amber',
                'is_highlighted' => false,
                'animation_type' => 'none',
                'sort_order' => 3,
            ],
            [
                'type' => 'link',
                'title' => 'Hubungi via Telegram',
                'subtitle' => 'Diskusi kolaborasi & konsultasi',
                'url' => 'https://t.me/windri',
                'icon' => 'send',
                'card_size' => 'half',
                'badge_text' => 'FAST CHAT',
                'badge_color' => 'purple',
                'is_highlighted' => false,
                'animation_type' => 'none',
                'sort_order' => 4,
            ],
        ];

        foreach ($links as $linkData) {
            BioLink::updateOrCreate(
                ['profile_id' => $profile->id, 'title' => $linkData['title']],
                [...$linkData, 'is_active' => true, 'open_in_new_tab' => true]
            );
        }
    }
}
