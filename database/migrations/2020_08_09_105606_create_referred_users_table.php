<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferredUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referred_users', function (Blueprint $table) {
            $table->id();
            $table->string('referral', 64);
            $table->string('ip', 64);
            $table->integer('logged')->comment('Unused, seems to be if people have logged in from this');
            $table->timestamp('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referred_users');
    }
}
