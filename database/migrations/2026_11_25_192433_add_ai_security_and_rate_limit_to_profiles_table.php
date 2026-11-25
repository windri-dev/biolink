<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->integer('ai_rate_limit_per_minute')->default(10)->after('ai_temperature');
            $table->integer('ai_rate_limit_per_hour')->default(60)->after('ai_rate_limit_per_minute');
            $table->boolean('ai_security_guard')->default(true)->after('ai_rate_limit_per_hour'); // Anti Prompt-Injection & Jailbreak
            $table->boolean('ai_content_filter')->default(true)->after('ai_security_guard'); // Filter kata kasar & pelecehan
            $table->integer('ai_block_duration_minutes')->default(15)->after('ai_content_filter'); // Durasi cooldown auto-ban IP
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'ai_rate_limit_per_minute',
                'ai_rate_limit_per_hour',
                'ai_security_guard',
                'ai_content_filter',
                'ai_block_duration_minutes',
            ]);
        });
    }
};
