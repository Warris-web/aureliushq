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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('payment_method')->nullable();
        $table->text('delivery_address')->nullable();
        $table->string('repayment_plan')->nullable();
        $table->string('has_paid_delivery_fee')->default('no');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['payment_method', 'delivery_address', 'repayment_plan', 'has_paid_delivery_fee']);
    });
}

};
