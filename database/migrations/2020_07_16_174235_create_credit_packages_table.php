<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_packages', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('amount');
            $table->integer('bonus');
            $table->integer('holiday_bonus');
            $table->integer('discount')->comment('This is a % amount');
            $table->double('price');
            $table->string('image_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_packages');
    }
}
