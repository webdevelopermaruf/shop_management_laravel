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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->integer('invoice_order_no');
            $table->string('invoice_holder');
            $table->string('invoice_holder_phone');
            $table->string('invoice_product');
            $table->string('invoice_barcode');
            $table->integer('invoice_factory');
            $table->integer('invoice_sell');
            $table->integer('invoice_discount');
            $table->integer('invoice_paid');
            $table->integer('invoice_qty');
            $table->timestamp('invoice_creation')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
};
