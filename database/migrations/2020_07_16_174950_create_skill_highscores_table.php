<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillHighscoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_highscores', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('userid');
            $table->string('username');
            $table->integer('mode');
            $table->integer('skill_mode_id');
            $table->string('skill_id');
            $table->string('skill_name_id');
            $table->integer('level');
            $table->integer('experience');
            $table->timestamp('last_modified');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_highscores');
    }
}
