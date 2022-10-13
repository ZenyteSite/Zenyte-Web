<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuellogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_duels', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('user', 16);
            $table->string('user_ip', 64);
            $table->integer('user_staked_coins')->comment('Optional integer for coins staked. Can be nullable')->nullable();
            $table->integer('user_staked_tokens')->comment('Optional integer for platinum tokens staked. Can be nullable')->nullable();
            $table->string('opponent', 16);
            $table->string('opponent_ip', 64);
            $table->integer('opponent_staked_coins')->comment('Optional integer for coins staked. Can be nullable')->nullable();
            $table->integer('opponent_staked_tokens')->comment('Optional integer for platinum tokens staked. Can be nullable')->nullable();
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
        Schema::dropIfExists('logs_duels');
    }
}
