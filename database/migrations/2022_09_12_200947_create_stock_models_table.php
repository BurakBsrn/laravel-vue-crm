<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('stock_id');
            $table->integer('stock_user_id')->nullable();
            $table->integer('stock_customer_id')->nullable();
            $table->integer('stock_type')->nullable();
            $table->integer('stock_isStock')->nullable();
            $table->integer('stock_product_id')->nullable();
            $table->integer('stock_quantity')->nullable();
            $table->float('stock_total_price',10,2)->nullable();
            $table->text('stock_note')->nullable();
            $table->date('stock_date')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
