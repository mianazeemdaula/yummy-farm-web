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
            $table->unsignedBigInteger('product_category_id');
            $table->string('packaging', 100)->nullable()->default('text');
            $table->string('detail', 100)->nullable();
            $table->string('species', 100)->nullable();
            $table->integer('age')->nullable()->default(0);
            $table->string('bio')->nullable();
            $table->string('grass_fed', 100)->nullable()->default('text');
            $table->string('lifestyle', 100)->nullable()->default('text');
            $table->text('content')->nullable();
            $table->integer('pieces')->default(1);
            $table->double('total_weight')->default(0.0);
            $table->double('priceexclVAT', 100)->default(0.0);
            $table->string('name', 100);
            $table->string('part', 100);
            $table->enum('delivery_method', ['take_away', 'delivery'])->nullable()->default('take_away');
            $table->dateTime('delivery_time', 100)->nullable();
            $table->string('extra_info', 100)->nullable();
            $table->integer('stock')->default(0);
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
        Schema::dropIfExists('products');
    }
}
