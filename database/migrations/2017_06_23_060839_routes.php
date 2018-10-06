<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Routes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {




        Schema::create('routes', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();

            $table->integer('req_id')->unsigned()->index('req_id');
            $table->integer('device_id')->unsigned()->index('device_id');
            $table->integer('client_id')->unsigned()->index('client_id');
            $table->integer('order')->unsigned();

            $table->enum('status', ['wait','sended','success','timeout'])->default('wait');
            $table->enum('answer', ['true','false'])->nullable();

            $table->dateTime('sended_dt')->nullable();
            $table->dateTime('answer_dt')->nullable();

            $table->dateTime('response_dt')->nullable();
            $table->integer('response_code')->nullable();

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
        Schema::drop('routes');

    }
}
