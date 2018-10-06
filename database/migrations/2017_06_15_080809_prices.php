<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Prices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned()->default(1);
        });

        Schema::create('user_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('plan_id');
            $table->integer('user_id');
        });



        Schema::create('price_plan', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('plan_limit', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('plan_id')->unsigned()->index('plan_id');

            $table->string('key');
            $table->string('value');
            $table->enum('period', ['anytime', 'day', 'week', 'month'])->default('anytime');

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
        Schema::drop('price_plan');


        Schema::drop('plan_limit');
    }
}
