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
            $table->string('name', 100);
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('species', 100)->nullable();
            $table->boolean('bio')->default(false);
            $table->double('priceexclVAT', 100)->default(0.0); //should be unit price
            $table->boolean('isPackage')->default(false); //can also be used for identifying packages
            $table->string('product_detail', 200)->default('text');  // it will serve as either individual product description or package description

            //stock is derivable

            $table->timestamps();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers')
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