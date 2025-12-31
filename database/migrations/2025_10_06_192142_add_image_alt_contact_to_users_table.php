<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'image')) {
                $table->text('image')->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'alt_phone')) {
                $table->string('alt_phone')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'alt_email')) {
                $table->string('alt_email')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'image')) {
                $table->dropColumn('image');
            }
            if (Schema::hasColumn('users', 'alt_phone')) {
                $table->dropColumn('alt_phone');
            }
            if (Schema::hasColumn('users', 'alt_email')) {
                $table->dropColumn('alt_email');
            }
        });
    }
};
