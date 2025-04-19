<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {Schema::create('cash_return_details', function (Blueprint $table) {
        $table->increments('id');
    
       

        $table->integer('qty');

        $table->unsignedInteger('store_product_id');
        $table->foreign('store_product_id')->references('id')->on('store_products');

        $table->unsignedInteger('unit_id')->unsigned();
        $table->foreign('unit_id')->references('id')->on('units');
        
        $table->integer('cash_return_id')->unsigned()->nullable();
        $table->foreign('cash_return_id')->references('id')->on('cash_returns')->onDelete('cascade');

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
        Schema::dropIfExists('cash_return_details');
    }
}
