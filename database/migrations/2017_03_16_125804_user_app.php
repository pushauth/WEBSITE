<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserApp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_app', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('public_key');
            $table->string('private_key');
            $table->string('plan')->default('free');
            $table->enum('status', ['enable','disable'])->default('disable');
            $table->string('urlhash');
            $table->text('name')->nullable();
            $table->text('about')->nullable();
            $table->text('url')->nullable();
            $table->text('ip_mask')->nullable();
            $table->string('img')->nullable();

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
        Schema::drop('user_app');
    }
}
