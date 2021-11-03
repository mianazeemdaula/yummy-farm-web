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
            $table->unsignedBigInteger('product_subcategory_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('species', 100)->nullable();
            $table->boolean('bio')->default(false);
            $table->double('priceexclVAT', 100)->default(0.0); //should be unit price

            // package as a single item but with specification

            // $table->string('packaging', 100)->nullable()->default('text');
            // $table->string('detail', 100)->nullable();
            // $table->integer('pieces')->default(1);
            // $table->double('total_weight')->default(0.0);
            // $table->enum('delivery_method', ['take_away', 'delivery'])->nullable()->default('take_away');
            // $table->dateTime('delivery_time')->nullable();
            // $table->string('extra_info', 100)->nullable();
            // $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_subcategory_id')
                ->references('id')
                ->on('product_subcategories')
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
