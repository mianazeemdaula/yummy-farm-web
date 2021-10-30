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
            $table->unsignedBigInteger('SellerId');
            $table->unsignedBigInteger('ProductCategoryId');
            $table->string('ProductPackaging', 100)->nullable()->default('text');
            $table->string('ProductDetail', 100)->nullable()->default('text');
            $table->string('ProductSpecies', 100)->nullable()->default('text');
            $table->unsignedInteger('ProductAge')->nullable()->default(0);
            $table->string('ProductBio')->nullable()->default('text');
            $table->string('ProductGrassfed', 100)->nullable()->default('text');
            $table->string('ProductLifestyle', 100)->nullable()->default('text');
            $table->string('ProductContent', 100)->nullable()->default('text');
            $table->integer('ProductPieces')->default(1);
            $table->double('ProductTotalWeight')->default(0.0);
            $table->string('ProductpriceexclVAT', 100)->nullable()->default('text');
            $table->string('ProductName', 100)->nullable()->default('text');
            $table->string('ProductDeliverymethod', 100)->nullable()->default('text');
            $table->tinyInteger('ProductDeliveryday')->default(1);
            $table->string('ProductDeliverytime', 100)->nullable()->default('text');
            $table->string('ProductExtrainfo', 100)->nullable()->default('text');
            $table->unsingedInteger('ProductStock')->default(0);
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
