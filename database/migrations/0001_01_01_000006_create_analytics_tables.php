<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Page views log with Geolocation
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('country_code', 4)->nullable()->index(); // ID, US, SG, etc.
            $table->string('country_name', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('device_type')->default('mobile'); // mobile, desktop, tablet
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->timestamp('viewed_at')->useCurrent();

            $table->index(['profile_id', 'viewed_at']);
        });

        // 2. Link clicks log with Geolocation
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bio_link_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('country_code', 4)->nullable()->index();
            $table->string('country_name', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('device_type')->default('mobile');
            $table->timestamp('clicked_at')->useCurrent();

            $table->index(['bio_link_id', 'clicked_at']);
        });

        // 3. AI chat sessions & interactions
        Schema::create('ai_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('session_id', 64)->index();
            $table->string('user_message');
            $table->longText('ai_response');
            $table->string('matched_intent')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['profile_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chats');
        Schema::dropIfExists('link_clicks');
        Schema::dropIfExists('page_views');
    }
};
