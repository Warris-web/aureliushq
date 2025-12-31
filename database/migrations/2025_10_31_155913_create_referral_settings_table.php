<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('referrer_reward', 10, 2)->default(500);
            $table->decimal('referred_reward', 10, 2)->default(200);
            $table->decimal('commission_percentage', 5, 2)->default(3.00);
            $table->text('referral_note')->nullable(); // new column for custom note
            $table->text('how_it_works')->nullable(); // new column for custom note
            $table->enum('display_referral_note', ['yes', 'no'])->default('yes'); // toggle to show/hide note
            $table->timestamps();
        });

        DB::table('referral_settings')->insert([
            'referrer_reward' => 500,
            'referred_reward' => 200,
            'commission_percentage' => 3.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_settings');
    }
};
