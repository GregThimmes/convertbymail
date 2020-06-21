<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('campaign_link', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_id')->unsigned();
            $table->integer('link_id')->unsigned();
            $table->string('link',512);
            $table->integer('clicks')->unsigned()->default(0);
            $table->integer('total')->unsigned()->default(0);
            $table->timestamps();
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
        Schema::drop('campaign_link');
    }
}
