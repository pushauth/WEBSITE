<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserEmailConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_email_confirm', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('email');
            $table->enum('status', ['true','false'])->default('false');
            $table->string('urlhash');
            $table->dateTime('confirm_dt')->nullable();
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
        Schema::drop('user_email_confirm');
    }
}
