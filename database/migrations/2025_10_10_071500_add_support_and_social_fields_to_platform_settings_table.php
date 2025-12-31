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
        Schema::table('platform_settings', function (Blueprint $table) {
            $table->string('support_phone')->nullable()->after('login_terms');
            $table->string('support_email')->nullable()->after('support_phone');
            $table->string('support_location')->nullable()->after('support_email');
            $table->string('social_facebook')->nullable()->after('support_location');
            $table->string('social_x_tiktok')->nullable()->after('social_facebook');
            $table->string('social_instagram')->nullable()->after('social_x_tiktok');
        });
    }

    public function down(): void
    {
        Schema::table('platform_settings', function (Blueprint $table) {
            $table->dropColumn([
                'support_phone',
                'support_email',
                'support_location',
                'social_facebook',
                'social_x_tiktok',
                'social_instagram',
            ]);
        });
    }
};
