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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referred_id')->nullable()->unique(); // each referred user can only appear once
            $table->string('referral_code'); // ❌ remove unique here
            $table->string('status')->default('pending'); // pending, completed
            $table->decimal('reward_amount', 10, 2)->default(0);
            $table->decimal('commission', 10, 2)->default(0);
            $table->boolean('reward_disbursed')->default(false);
            $table->timestamps();
        
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
        
            // ✅ Add index for performance
            $table->index('referral_code');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
