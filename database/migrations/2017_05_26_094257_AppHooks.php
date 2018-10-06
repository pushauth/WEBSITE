<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppHooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('app_hook', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->integer('app_id')->unsigned()->index('app_id');
            $table->string('hash');
            $table->string('payload_url')->nullable();
            $table->enum('type',['form','json'])->default('json');

            $table->enum('qr_flag',['true','false'])->default('true');
            $table->enum('push_flag',['true','false'])->default('true');
            $table->enum('timeout_flag',['true','false'])->default('true');

            $table->enum('status',['enable','disable'])->default('disable');



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
        Schema::drop('app_hook');
    }
}
