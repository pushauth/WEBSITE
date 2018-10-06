<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhExchanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dh_exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('device_id')->unsigned()->index('device_id');
            $table->string('hash');

            $table->string('val_g')->nullable();
            $table->string('val_p')->nullable();
            $table->string('val_ak')->nullable();
            $table->string('val_bk')->nullable();
            $table->string('val_a')->nullable();
            $table->string('val_b')->nullable();




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
        Schema::drop('dh_exchanges');
    }
}
