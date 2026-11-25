<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->boolean('is_verified')->default(true);
            $table->string('verified_title')->default('Verified Creator');
            $table->string('badge_style')->default('blue'); // blue, gold, purple, emerald
            $table->boolean('show_share_button')->default(true);
            $table->boolean('show_subscribe_box')->default(false);
            $table->boolean('ai_assistant_enabled')->default(true);
            $table->string('ai_assistant_name')->default('Aura');
            $table->string('ai_greeting_message')->default('Halo! Saya asisten AI Windri. Ada yang bisa saya bantu terkait proyek, kolaborasi, atau kontak? ✨');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('custom_css')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
