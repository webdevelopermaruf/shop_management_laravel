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
        Schema::create('return_product', function (Blueprint $table) {
            $table->id('rp_id');
            $table->string('ro_product_name');
            $table->string('ro_product_barcode');
            $table->integer('return_qty');
            $table->integer('pre_order_no');
            $table->integer('rp_order_no')->nullable();
            $table->timestamp('rp_creation')->useCurrent();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_product');
    }
};
