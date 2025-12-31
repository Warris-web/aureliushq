<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->text('home_address')->nullable(); // adjust position if needed
        $table->bigInteger('wallet_balance')->default(0);
        $table->bigInteger('loan_balance')->default(0);
        $table->string('last_payment_method')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['home_address', 'wallet_balance', 'loan_balance', 'last_payment_method']);
    });
}

};
