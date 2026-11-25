<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_knowledges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->string('category')->default('general'); // bio, project, experience, contact, pricing, faq
            $table->string('title'); // e.g. "Pengalaman Kerja", "Proyek Shoppe", "Kontak Kolaborasi"
            $table->text('keywords')->nullable(); // comma-separated keywords for intent matching
            $table->longText('content'); // detailed answer / factual info
            $table->string('suggested_prompt')->nullable(); // quick chip prompt for visitor (e.g. "Apa proyek terbarumu?")
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['profile_id', 'is_active', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_knowledges');
    }
};
