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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('utility_bill_file')->nullable();
            $table->string('bank_statement')->nullable();
            $table->string('bvn')->nullable();
            $table->string('hidden_loan')->nullable();
            $table->decimal('repayment_amount', 12, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'utility_bill_file',
                'bank_statement',
                'bvn',
                'hidden_loan',
                'repayment_amount',
            ]);
        });
    }
};
