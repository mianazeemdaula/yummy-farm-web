<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('social_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('role')->default('customer');
            //
            $table->string('firstname')->nullable();
            $table->string('username')->nullable();
            $table->string('business_name')->nullable();
            $table->string('seller_number')->nullable();
            $table->string('address')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('country')->nullable();
            $table->point('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('vat')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('rpr')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->boolean('enable_notification')->nullable()->default(true);
            $table->string('description')->nullable();
            $table->string('status')->default('incomplete');
            $table->string('lang')->default('en');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
