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
        Schema::create('return_order', function (Blueprint $table) {
            $table->id('ro_id');
            $table->string('ro_cus_name');
            $table->string('ro_cus_phone');
            $table->integer('pre_order_no');
            $table->integer('exchange_order_no')->nullable();
            $table->integer('ro_qty');
            $table->integer('ro_money');
            $table->timestamp('ro_creation')->useCurrent();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_order');
    }
};
