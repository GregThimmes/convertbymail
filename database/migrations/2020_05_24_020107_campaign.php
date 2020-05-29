<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Campaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 
        Schema::create('campaign', function (Blueprint $table) {
            $table->id();
            $table->integer('io_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->date('broadcast_date');
            $table->text('name');
            $table->integer('quantity')->unsigned();
            $table->string('subject_line',512);
            $table->string('friendly_from', 255);
            $table->string('notes')->nullable();
            $table->text('creative');
            $table->text('creative_o');
            $table->char('fulfilled',1)->nullable();
            $table->char('approved',1)->nullable();
            $table->char('assigned',1)->nullable();
            $table->integer('sales_rep_id')->unsigned();
            $table->tinyInteger('active')->default(1);
            $table->string('ref',100)->nullable();
            $table->float('o_rate');
            $table->char('referral',1)->nullable();
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
        Schema::drop('campaign');
    }
}
