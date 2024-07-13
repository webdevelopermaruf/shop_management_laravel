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
        Schema::create('adminlog', function (Blueprint $table) {
            $table->id('admin_no');
            $table->string('admin_name');
            $table->string('admin_phone');
            $table->string('admin_email');
            $table->string('admin_password');
            $table->string('admin_address')->nullable();
            $table->integer('admin_role');
            $table->timestamp('admin_creation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adminlog');
    }
};
