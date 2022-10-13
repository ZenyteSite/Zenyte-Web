<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement_sites', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('website', 64);
            $table->string('link', 128);
            $table->integer('cost');
            $table->integer('total_clicks');
            $table->integer('unique_clicks');
            $table->integer('logins');
            $table->timestamp('date_added');
            $table->timestamp('date_expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisement_sites');
    }
}
