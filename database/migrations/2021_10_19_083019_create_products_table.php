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
            // $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('species', 100)->nullable();
            $table->boolean('bio')->default(false);
            $table->double('price')->default(0.0);
            $table->double('vat')->default(0.0);
            $table->integer('stock')->default(1);
            $table->integer('weight')->default(0);
            $table->enum('delivery_type', ['take away', 'delivery'])->default('take away');
            $table->string('extra_info', 200)->nullable();
            $table->text('description')->nullable();
            // $table->unsignedBigInteger('parent')->nullable();
            //stock is derivable

            $table->timestamps();

            // $table->foreign('product_category_id')
            //     ->references('id')
            //     ->on('product_categories')
            //     ->onUpdate('cascade')
            //     ->onDelete('cascade');

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