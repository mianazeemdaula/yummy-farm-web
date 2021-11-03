<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('report_by');
            $table->unsignedBigInteger('report_to');
            $table->string('comment');
            $table->timestamps();
            $table->foreign('report_by')->references('id')->on('users');
            $table->foreign('report_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_users');
    }
}
