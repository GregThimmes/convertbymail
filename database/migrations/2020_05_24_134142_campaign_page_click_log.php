<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignPageClickLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('campaign_page_click_log', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id')->unsigned();
            $table->integer('link_id')->unsigned();
            $table->string('ipaddress',100);
            $table->string('city',100)->nullable();
            $table->char('state',10)->nullable();
            $table->char('zip',10)->nullable();
            $table->float('lat');
            $table->float('lng');
            $table->timestamp('date', 0);
            $table->integer('open_click')->unsigned();
            $table->tinyInteger('is_valid');
            $table->integer('source')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('campaign_page_click_log');
    }
}
