<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_details', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('supply_id');
            $table->foreign('supply_id')->references('id')->on('supplies')->onDelete('cascade');

            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            $table->unsignedInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');

            $table->string('qty')->default(0);
            $table->string('price')->default(0);
            $table->integer('qty_return')->default(0);
            
            // $table->unsignedInteger('unit_id');
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');

            $table->string('total');

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
        Schema::dropIfExists('supply_details');
    }
}
