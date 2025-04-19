<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->Increments('id');
            // ---------------------------------------------------------------------------
            $table->unsignedInteger('product_unit_id')->nullable();
            $table->foreign('product_unit_id')->references('id')->on('product_units');
            // ---------------------------------------------------------------------------
            // $table->unsignedInteger('family_attribute_option_id')->nullable();
            // $table->foreign('family_attribute_option_id')->references('id')->on('family_attribute_options');
            $table->unsignedInteger('store_product_id')->nullable();
            $table->foreign('store_product_id')->references('id')->on('store_products');
            // ---------------------------------------------------------------------------

            $table->integer('price1')->nullable();


            $table->integer('price2')->nullable();


            $table->integer('price3')->nullable();




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
        Schema::dropIfExists('product_prices');
    }
}
