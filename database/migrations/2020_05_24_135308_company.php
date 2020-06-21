<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('address',100)->nullable();
            $table->string('address2',100)->nullable();
            $table->string('city',50)->nullable();
            $table->char('state',2)->nullable();
            $table->integer('zip')->nullable();
            $table->integer('phone')->nullable();
            $table->integer('fax')->nullable();
            $table->string('website',100)->nullable();
            $table->tinyInteger('active')->unsigned()->default(1);
            $table->float('o_rate');
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
        Schema::drop('company');
    }
}
