<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_payments', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('username');
            $table->string('email');
            $table->string('item_name');
            $table->double('paid');
            $table->integer('credit_amount');
            $table->string('status');
            $table->string('client_ip');
            $table->string('cvc_pass', 20); //The person who processed the transaction? (staff member in terms of osrs gp)
            $table->string('zip_pass', 20); //Payment method, can be bond
            $table->string('address_pass', 20); //The group that processed it e.g. mod, admin, paypal(basically same as zip_pass)
            $table->tinyInteger('live_mode');
            $table->timestamp('paid_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_payments');
    }
}
