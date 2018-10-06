<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PushRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('push_requests', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->integer('app_id')->unsigned()->index('app_id');
            $table->integer('device_id')->unsigned()->index('device_id')->nullable();
            $table->string('hash');
            $table->enum('mode',['push','code','qr','route'])->default('push');
            $table->enum('answer',['true','false'])->nullable();
            $table->dateTime('response_dt')->nullable();
            $table->integer('response_code')->nullable();
            $table->text('response_message')->nullable();
            $table->string('uniq_request_id')->nullable();
            $table->string('code')->nullable();
            $table->enum('test',['true','false'])->default('false');



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
        Schema::drop('push_requests');
    }
}
