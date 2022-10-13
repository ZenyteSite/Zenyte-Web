<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credits', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id');
            $table->string('username', 20);
            $table->integer('credits')->comment('This is our current credits and will be added to and subtracted when we perform actions');
            $table->integer('total_credits')->comment('This is used as a running tally of how many credits we have ever received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_credits');
    }
}
