<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunishmentActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punishment_actions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('mod_name');
            $table->string('offender');
            $table->string('action_type')->comment('This can be "kick", "mute", "ban", "ip-ban" or "mac-ban"');
            $table->string('expires');
            $table->string('reason');
            $table->string('ip_address', 64);
            $table->string('mac_address', 64);
            $table->timestamp('punished_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punishment_actions');
    }
}
