<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orders_id');
            $table->string('orders_holder');
            $table->string('orders_holder_phone');
            $table->integer('orders_purchase_price');
            $table->integer('orders_sell_price');
            $table->integer('orders_discount_price');
            $table->integer('orders_grand_price');
            $table->timestamp('orders_creation')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');

    }
};
