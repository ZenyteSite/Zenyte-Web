<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdventurersLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advlog', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('user', 16);
            $table->string('icon', 64);
            $table->string('message', 256);
            $table->string('type')->default('game');
            $table->integer('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advlog');
    }
}
