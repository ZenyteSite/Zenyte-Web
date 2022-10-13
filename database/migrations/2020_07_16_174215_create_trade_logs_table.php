<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_trades', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('user', 16);
            $table->string('user_ip', 64);
            $table->string('given', 2064);
            $table->string('partner', 16);
            $table->string('partner_ip', 64);
            $table->string('received', 2048);
            $table->integer('world');
            $table->timestamp('time_added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_trades');
    }
}
