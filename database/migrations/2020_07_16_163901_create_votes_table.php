<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id');
            $table->string('username');
            $table->string('vote_key');
            $table->integer('site_id');
            $table->timestamp('voted_on')->nullable()->comment('This is for when we get a positive response back from the toplist');
            $table->timestamp('started_on')->nullable();
            $table->tinyInteger('claimed');
            $table->timestamp('claimed_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
