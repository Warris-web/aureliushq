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
        Schema::create('kyc_levels', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // e.g. low, medium, high, market_woman
            $table->string('title');
            $table->longText('description');
            $table->string('repayment_period')->nullable();
            $table->string('credit_limit')->nullable();
            $table->integer('credit_amount_limit')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_levels');
    }
};
