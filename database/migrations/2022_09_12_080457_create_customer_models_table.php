<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->integer('customer_user_id')->nullable();
            $table->integer('customer_type')->nullable()->comment("1 ise tedarikçi, 2 ise müşteri");
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->unique()->nullable();
            $table->string('customer_phone')->unique()->nullable();
            $table->string('customer_address')->nullable();
            $table->text('customer_note')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
