<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunishmentActionProofsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punishment_action_proofs', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('action_id');
            $table->string('url', 128)->nullable();
            $table->text('notes')->nullable();
            $table->string('staff_member', 16);
            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punishment_action_proofs');
    }
}
