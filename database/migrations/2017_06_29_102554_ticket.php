<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ticket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tickets', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('author_id')->unsigned()->index('author_id');
            $table->enum('status', ['open', 'work', 'close'])->default('open');
            $table->string('subject');
            $table->longText('text');
            $table->string('type');

            $table->string('app_id')->nullable();
            $table->longText('error_msg')->nullable();
            $table->dateTime('issue_dt')->nullable();
            $table->string('url_hash')->unique()->index('url_hash');

            $table->timestamps();


        });

        Schema::create('ticket_thread', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('ticket_id')->unsigned()->index('ticket_id');
            $table->integer('author_id')->unsigned()->index('author_id');
            $table->longText('text');
            $table->string('url_hash')->unique()->index('url_hash');
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
        Schema::drop('tickets');
        Schema::drop('ticket_thread');

    }
}
