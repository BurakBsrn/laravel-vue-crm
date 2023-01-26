<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->integer('product_user_id')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_model_code')->nullable();
            $table->string('product_barcode')->nullable();
            $table->string('product_brand')->nullable();
            $table->integer('product_stock')->default(0)->nullable();
            $table->string('product_image')->nullable();
            $table->text('product_description')->nullable();
            $table->float('product_buying_price',10,2)->nullable();
            $table->float('product_selling_price',10,2)->nullable();
            $table->integer('product_tax')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
