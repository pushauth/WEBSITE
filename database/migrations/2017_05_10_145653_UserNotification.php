<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_notification', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('subject');
            $table->text('body');
            $table->enum('is_read', ['true','false'])->default('false');
            $table->string('urlhash');
            $table->dateTime('read_dt')->nullable();
            // $table->enum('with_user', ['true','false'])->default('false');



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
        Schema::drop('user_notification');
    }
}
