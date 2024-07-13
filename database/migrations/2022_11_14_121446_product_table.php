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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->integer('product_category');
            $table->string('product_barcode');
            $table->string('product_sku')->nullable();
            $table->integer('product_qty');
            $table->integer('product_sold')->default(0);
            $table->integer('product_purchase_price');
            $table->integer('product_sell_price');
            $table->string('product_image')->default('products/default.jpg')->nullable(); 
            $table->timestamp('product_creation'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
