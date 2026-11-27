<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AiKnowledge;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class AiKnowledgeSeeder extends Seeder
{
    public function run(): void
    {
        $profile = Profile::first();

        $knowledges = [
            [
                'category' => 'bio',
                'title' => 'Tentang Windri & Profil Keahlian',
                'keywords' => 'siapa, tentang, profil, background, keahlian, biodata, engineer, developer, skil',
                'content' => "Windri adalah seorang Senior Full-Stack Software Engineer & Builder yang berfokus pada arsitektur sistem terdistribusi, modern web development (PHP/Laravel, Node.js, Python), automasi cloud/server, dan rekayasa AI agents. Dikenal memegang prinsip 'Understand Before Implement' dengan standar kualitas kode production-grade.",
                'suggested_prompt' => 'Siapa itu Windri?',
                'sort_order' => 1,
            ],
            [
                'category' => 'project',
                'title' => 'Proyek Unggulan & Repositori',
                'keywords' => 'proyek, repo, github, portfolio, aplikasi, karya',
                'content' => "Beberapa proyek unggulan yang dikembangkan Windri:\n1. **BioLink Platform SaaS** (https://bio.wn-cdn.net): Platform agregasi tautan mandiri dengan keamanan enterprise dan integrasi CV digital.\n2. **Infrastruktur & Automasi Keamanan NetBird**: Sistem auto-defense sentinel multi-node.\nSemua kode terbuka dapat dicek langsung di GitHub resmi @windri-dev.",
                'suggested_prompt' => 'Apa saja proyek yang pernah dibuat?',
                'sort_order' => 2,
            ],
            [
                'category' => 'contact',
                'title' => 'Kontak & Kolaborasi Bisnis',
                'keywords' => 'kontak, hubungi, email, telegram, whatsapp, kolaborasi, hire, kerja sama, konsultasi',
                'content' => "Anda dapat menghubungi Windri langsung melalui:\n• **Telegram**: @windri (Respons tercepat untuk diskusi proyek atau konsultasi teknis)\n• **Email**: mail262@gmail.com\n• **GitHub**: https://github.com/windri-dev\nSilakan sampaikan topik diskusi atau proposal kerja sama dengan jelas.",
                'suggested_prompt' => 'Bagaimana cara menghubungi Windri?',
                'sort_order' => 3,
            ],
            [
                'category' => 'experience',
                'title' => 'Stack Teknologi yang Dikuasai',
                'keywords' => 'stack, teknologi, bahasa pemrograman, framework, database, laravel, docker, linux',
                'content' => "Stack utama yang digunakan meliputi:\n• **Backend**: Modern PHP 8.4 & Laravel 11/12, Python, Node.js\n• **Frontend**: Tailwind CSS, Alpine.js, Blade, Vue/React\n• **Database**: MySQL, PostgreSQL, Redis, SQLite\n• **DevOps & Infra**: Docker, Linux VPS Hardening, Nginx, NetBird VPN, WireGuard, Cloudflare Tunnels",
                'suggested_prompt' => 'Apa saja tech stack yang dikuasai?',
                'sort_order' => 4,
            ],
        ];

        foreach ($knowledges as $kData) {
            AiKnowledge::updateOrCreate(
                ['profile_id' => $profile->id, 'title' => $kData['title']],
                [...$kData, 'is_active' => true]
            );
        }
    }
}
