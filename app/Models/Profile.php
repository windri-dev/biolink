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
        'enable_cv',
        'cv_headline',
        'cv_summary',
        'cv_skills',
        'cv_experiences',
        'cv_educations',
        'cv_file_url',
        'cv_template',
        'meta_title',
        'meta_description',
        'custom_css',
        'is_flagged',
        'admin_notes',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_flagged' => 'boolean',
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
            'enable_cv' => 'boolean',
            'cv_skills' => 'array',
            'cv_experiences' => 'array',
            'cv_educations' => 'array',
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

    /**
     * Returns professional default CV template preset data
     *
     * @return array<string, mixed>
     */
    public static function getDefaultCvPreset(): array
    {
        return [
            'enable_cv' => true,
            'cv_headline' => 'Senior Full-Stack Software Engineer & System Architect',
            'cv_summary' => 'Software Engineer berpengalaman lebih dari 5 tahun dalam merancang dan mengembangkan sistem web berskala besar, API berkinerja tinggi, integrasi AI Agent, serta arsitektur cloud. Terbiasa memimpin inisiatif teknis dari konsep hingga rilis produksi dengan fokus pada kehandalan, keamanan (AppSec), dan skalabilitas data.',
            'cv_template' => 'modern',
            'cv_skills' => [
                'Backend & Architecture' => ['PHP (Laravel 11+)', 'Python (FastAPI)', 'Node.js / Express', 'RESTful & GraphQL API', 'Microservices', 'Redis Cache-Aside'],
                'Frontend & UI/UX' => ['Tailwind CSS', 'Alpine.js', 'Vue.js / React', 'Responsive Design', 'A11y (WCAG AA)', 'Figma to Code'],
                'Database & Storage' => ['MySQL / MariaDB (High Perf Indexing)', 'PostgreSQL', 'Database Query Optimization', 'S3 Object Storage'],
                'DevOps & Security' => ['Docker & Containerization', 'CI/CD Pipeline (GitHub Actions)', '2FA (TOTP RFC 6238)', 'AppSec (AES-256, CSRF Guard)', 'Nginx & Linux Server']
            ],
            'cv_experiences' => [
                [
                    'company' => 'windri-dev Digital Studio',
                    'role' => 'Lead Full-Stack Engineer',
                    'location' => 'Jakarta, Indonesia',
                    'period' => '2022 - Sekarang',
                    'description' => "• Memimpin arsitektur dan pengembangan platform SaaS BioLink & e-commerce SHOPPE berbasis Laravel modern dan Tailwind CSS.\n• Mengimplementasikan integrasi AI Assistant berbasis LLM dengan sistem filter keamanan prompt injection dan rate limiter dinamis.\n• Merancang arsitektur keamanan enterprise termasuk Autentikasi Dua Faktor (2FA TOTP RFC 6238) dan enkripsi AES-256."
                ],
                [
                    'company' => 'Tech Innovation Lab',
                    'role' => 'Senior Backend Developer',
                    'location' => 'Jakarta, Indonesia',
                    'period' => '2020 - 2022',
                    'description' => "• Mengembangkan microservices API berkapasitas throughput tinggi dengan rata-rata response time < 45ms.\n• Mengoptimalkan skema database relational dan Redis cache-aside sehingga menghemat beban CPU server sebesar 40%.\n• Membangun automated testing (Unit & Feature Tests) dengan standar code coverage di atas 85%."
                ],
                [
                    'company' => 'Digital Creative Agency',
                    'role' => 'Web Developer',
                    'location' => 'Bandung, Indonesia',
                    'period' => '2018 - 2020',
                    'description' => "• Merancang dan merilis lebih dari 20+ web portal dan dashboard interaktif untuk klien korporat dan UMKM.\n• Mengimplementasikan integrasi payment gateway (Midtrans / Xendit) dan webhook otomatis yang reliabel."
                ]
            ],
            'cv_educations' => [
                [
                    'school' => 'Universitas Komputer & Teknologi',
                    'degree' => 'Sarjana Komputer (S.Kom)',
                    'field_of_study' => 'Teknik Informatika / Ilmu Komputer',
                    'period' => '2014 - 2018',
                    'gpa' => '3.82 / 4.00',
                    'description' => 'Fokus pada Rekayasa Perangkat Lunak, Struktur Data & Algoritma, dan Keamanan Sistem Komputer. Lulus dengan predikat Cum Laude.'
                ]
            ],
        ];
    }
}
