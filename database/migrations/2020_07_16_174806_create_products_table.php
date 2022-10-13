<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('item_name');
            $table->integer('category_id');
            $table->integer('item_id');
            $table->integer('item_amount');
            $table->double('item_price');
            $table->double('item_discount');
            $table->tinyInteger('ironman');
            $table->text('description')->comment('This will hold markdown');
            $table->tinyInteger('visible');
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('bond_amount')->nullable();
            $table->timestamps();
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
}
