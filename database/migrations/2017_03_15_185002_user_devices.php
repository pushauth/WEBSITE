<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('os');
            $table->text('uuid');
            $table->text('token');
            $table->text('public_key')->nullable();
            $table->text('private_key')->nullable();
            $table->enum('status', ['enable','disable'])->default('enable');


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
        Schema::drop('user_devices');
    }
}
