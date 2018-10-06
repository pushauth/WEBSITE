<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_stripe', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->enum('status', ['enable', 'disable'])->default('disable');

            $table->string('customer_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('plan_id')->nullable();

            $table->enum('error_status', ['true', 'false'])->default('false');

            $table->dateTime('current_period_end')->nullable();

            $table->timestamps();


        });

        Schema::create('user_stripe_cards', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');

            $table->string('card_id')->nullable();
            $table->string('last4')->nullable();
            $table->integer('exp_month')->nullable();
            $table->integer('exp_year')->nullable();
            $table->string('brand')->nullable();
            $table->string('hash')->nullable();

            $table->enum('default', ['true', 'false'])->default('false');
            $table->dateTime('attempt_dt');
            //attempt

            $table->timestamps();


        });

        Schema::create('user_stripe_invoice', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('invoice_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount')->nullable();

            $table->enum('paid', ['true', 'false'])->default('false');

            $table->dateTime('period_start')->nullable();
            $table->dateTime('period_end')->nullable();

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
        Schema::drop('user_stripe');
        Schema::drop('user_stripe_cards');
    }
}
