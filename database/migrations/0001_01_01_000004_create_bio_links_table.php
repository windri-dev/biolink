<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bio_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('link'); // link, header, embed_youtube, embed_spotify, contact_card
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('url')->nullable();
            $table->string('icon')->nullable(); // Lucide icon or custom SVG
            $table->string('thumbnail_url')->nullable();
            $table->string('card_size')->default('full'); // full (100%), half (50% 2-col bento), featured (large prominent)
            $table->string('badge_text')->nullable(); // "NEW", "HOT", "PROMO", "STAGING", etc.
            $table->string('badge_color')->default('emerald'); // emerald, amber, rose, sky, purple
            $table->boolean('is_highlighted')->default(false); // subtle pulse/glow animation
            $table->string('animation_type')->default('none'); // none, pulse, bounce, shimmer
            $table->boolean('open_in_new_tab')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->unsignedBigInteger('total_clicks')->default(0);
            $table->timestamps();

            $table->index(['profile_id', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bio_links');
    }
};
