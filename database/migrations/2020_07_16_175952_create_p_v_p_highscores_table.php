<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePVPHighscoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pvp_highscores', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('userid');
            $table->string('username');
            $table->integer('kills');
            $table->integer('deaths');
            $table->integer('killstreak');
            $table->integer('shutdown');
            $table->integer('pk_rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pvp_highscores');
    }
}
