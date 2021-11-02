<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    //     /**
    //      * Run the migrations.
    //      *
    //      * @return void
    //      */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            //             $table->string('firstname')->nullable();
            //             $table->string('username')->nullable();
            //             $table->string('business_name')->nullable();
            //             $table->string('seller_number')->nullable();
            //             $table->string('address_one')->nullable();
            //             $table->string('address_two')->nullable();
            //             $table->point('location')->nullable();
            //             $table->string('phone')->nullable();
            //             $table->string('vat')->nullable();
            //             $table->string('bank_account')->nullable();
            //             $table->string('rpr')->nullable();
            //             $table->unsignedBigInteger('subscription_id')->nullable();
            //             $table->boolean('enable_notification')->nullable()->default(true);
            //             $table->timestamps();
        });
    }

    //     /**
    //      * Reverse the migrations.
    //      *
    //      * @return void
    //      */
    public function down()
    {
        //         Schema::dropIfExists('sellers');
    }
}