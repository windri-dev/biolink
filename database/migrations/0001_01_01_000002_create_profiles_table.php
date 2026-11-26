<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('theme_id')->nullable()->constrained('themes')->nullOnDelete();
            $table->string('handle')->unique(); // e.g. windri or @windri
            $table->string('display_name');
            $table->string('avatar_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('tagline')->nullable(); // e.g. "Full-Stack Software Engineer & Builder"
            $table->string('location')->nullable(); // e.g. "Jakarta, Indonesia"
            $table->string('phone')->nullable(); // For vCard download
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->boolean('enable_vcard')->default(true);
            $table->boolean('enable_bento_grid')->default(true);
            $table->boolean('is_verified')->default(true);
            $table->string('verified_title')->default('Verified Creator');
            $table->string('badge_style')->default('blue'); // blue, gold, purple, emerald
            $table->boolean('show_share_button')->default(true);
            $table->boolean('show_subscribe_box')->default(false);

            // AI Assistant Core & API Settings
            $table->boolean('ai_assistant_enabled')->default(true);
            $table->string('ai_assistant_name')->default('Aura');
            $table->string('ai_avatar_url', 1000)->nullable();
            $table->string('ai_greeting_message')->default('Halo, saya asisten AI. Ada yang bisa saya bantu terkait proyek, kolaborasi, atau kontak?');
            $table->string('ai_provider')->default('local'); // local, openai, custom
            $table->text('ai_api_key')->nullable();
            $table->string('ai_api_base')->default('https://api.openai.com/v1')->nullable();
            $table->string('ai_model')->default('gpt-4o-mini')->nullable();
            $table->text('ai_system_prompt')->nullable();
            $table->float('ai_temperature')->default(0.7);

            // AI Rate Limiting & Security Guardrails
            $table->integer('ai_rate_limit_per_minute')->default(10);
            $table->integer('ai_rate_limit_per_hour')->default(60);
            $table->boolean('ai_security_guard')->default(true); // Anti Prompt-Injection & Jailbreak
            $table->boolean('ai_content_filter')->default(true); // Filter kata kasar & pelecehan
            $table->integer('ai_block_duration_minutes')->default(15); // Durasi cooldown auto-ban IP

            // Professional Curriculum Vitae (CV) & Career Builder
            $table->boolean('enable_cv')->default(true);
            $table->string('cv_headline')->nullable();
            $table->text('cv_summary')->nullable();
            $table->json('cv_skills')->nullable();
            $table->json('cv_experiences')->nullable();
            $table->json('cv_educations')->nullable();
            $table->string('cv_file_url', 1000)->nullable();
            $table->string('cv_template')->default('modern');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('custom_css')->nullable();
            $table->boolean('is_flagged')->default(false);
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
