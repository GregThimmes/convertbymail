<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertionOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('insertion_order', function (Blueprint $table) {
            $table->id();
            $table->integer('internal_id');
            $table->tinyInteger('client_id');
            $table->tinyInteger('contact_id')->default(0);
            $table->tinyInteger('sales_rep_id');
            $table->string('name',50)->nullable();
            $table->char('type',1)->default('c');
            $table->char('status',1)->default('o');
            $table->integer('quantity');
            $table->string('notes',255)->nullable();
            $table->tinyInteger('active')->unsigned()->default(1);
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
        Schema::drop('insertion_order');
    }
}
