<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false)->after('password');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->index()->after('is_super_admin');
            }
        });

        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'is_flagged')) {
                $table->boolean('is_flagged')->default(false);
            }
            if (!Schema::hasColumn('profiles', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['is_flagged', 'admin_notes']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_super_admin', 'status']);
        });
    }
};
