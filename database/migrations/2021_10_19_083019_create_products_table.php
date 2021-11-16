<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_id');
            $table->boolean('individual')->default(true);
            $table->string('name', 100);
            $table->string('self_category', 50)->nullable();
            $table->string('species', 100)->nullable();
            $table->string('body_part', 100)->nullable();
            $table->integer('pieces')->nullable();
            $table->integer('age')->nullable();
            $table->string('life_style',50)->nullable();
            $table->boolean('bio')->default(false);
            $table->integer('weight')->default(0);
            $table->double('price')->default(0.0);
            $table->double('vat')->default(0.0);
            $table->integer('stock')->default(1);
            $table->enum('delivery_type', ['take_away', 'delivery'])->nullable();
            $table->dateTime('delivery_date')->nullable();
            $table->text('description')->nullable();
            $table->string('extra_info', 200)->nullable();

            $table->timestamps();

            $table->foreign('seller_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}