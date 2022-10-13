<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_sites', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('title');
            $table->string('voteid')->nullable();
            $table->string('url');
            $table->tinyInteger('visible');
            $table->string('ipAddress', 64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_sites');
    }
}
