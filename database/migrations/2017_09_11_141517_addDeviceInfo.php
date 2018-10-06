<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeviceInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //
        Schema::table('user_devices', function (Blueprint $table) {


            //Iphone' Yaroslav
            $table->text('name')->nullable();

            //Iphone 6S White
            $table->text('vendor')->nullable();

            //iOS 11.0.1 beta
            $table->text('os_detail')->nullable();


        });


        //user_device_confirm

        Schema::table('user_device_confirm', function (Blueprint $table) {


            //Iphone' Yaroslav
            $table->text('name')->nullable();

            //Iphone 6S White
            $table->text('vendor')->nullable();

            //iOS 11.0.1 beta
            $table->text('os_detail')->nullable();


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
    }
}
