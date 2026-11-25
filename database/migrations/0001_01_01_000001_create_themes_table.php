<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('background_type')->default('gradient'); // solid, gradient, mesh, glassmorphism
            $table->text('background_value'); // CSS background string / gradient hex
            $table->string('card_bg')->default('rgba(255, 255, 255, 0.08)');
            $table->string('card_border')->default('rgba(255, 255, 255, 0.15)');
            $table->string('card_text')->default('#ffffff');
            $table->string('card_hover_bg')->default('rgba(255, 255, 255, 0.16)');
            $table->string('text_color')->default('#ffffff');
            $table->string('subtext_color')->default('#9ca3af');
            $table->string('accent_color')->default('#38bdf8');
            $table->string('font_family')->default('Inter, sans-serif');
            $table->string('button_shape')->default('rounded-2xl'); // rounded-lg, rounded-2xl, rounded-full
            $table->boolean('is_dark')->default(true);
            $table->boolean('is_preset')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
