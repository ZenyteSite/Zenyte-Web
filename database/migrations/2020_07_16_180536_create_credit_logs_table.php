<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_logs', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('author', 16);
            $table->string('recipient', 16);
            $table->integer('credits');
            $table->timestamp('given_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credit_logs');
    }
}
