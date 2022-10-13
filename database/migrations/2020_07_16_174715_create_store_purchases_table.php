<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_purchases', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('userid');
            $table->string('username', 20);
            $table->string('trans_id');
            $table->integer('item_id');
            $table->integer('item_amount');
            $table->string('item_name');
            $table->integer('quantity');
            $table->double('price');
            $table->double('discount');
            $table->tinyInteger('claimed');
            $table->timestamp('bought_on');
            $table->timestamp('claimed_on')->nullable();
            $table->string('claimed_ip')->nullable();
            $table->string('claimed_mac')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_purchases');
    }
}
