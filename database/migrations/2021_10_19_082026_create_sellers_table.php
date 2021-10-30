<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('SellerName')->nullable();
            $table->string('SellerFirstname')->nullable();
            $table->string('SellerUsername')->nullable();
            $table->string('SellerBusinessname')->nullable();
            $table->string('SellerNumber')->nullable();
            $table->string('SellerAddressline1')->nullable();
            $table->string('SellerAddressline2')->nullable();
            $table->point('location')->nullable();
            $table->string('Sellerphone')->nullable();
            $table->string('SellerVAT')->nullable();
            $table->string('SellerBankaccount')->nullable();
            $table->string('SellerRPR')->nullable();
            $table->unsignedBigInteger('SellerSubscriptionId')->nullable();
            $table->boolean('SellerNotifications')->nullable()->default(true);
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
        Schema::dropIfExists('sellers');
    }
}
