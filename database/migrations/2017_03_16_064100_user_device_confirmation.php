<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDeviceConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_device_confirm', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->index('user_id')->nullable();
            $table->string('os');
            $table->text('uuid');
            $table->text('token');
            $table->enum('status', ['true','false'])->default('false');
            $table->string('urlhash');
            $table->dateTime('confirm_dt')->nullable();
            $table->enum('with_user', ['true','false'])->default('false');
            $table->string('email')->nullable();


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
        Schema::drop('user_device_confirm');
    }
}
