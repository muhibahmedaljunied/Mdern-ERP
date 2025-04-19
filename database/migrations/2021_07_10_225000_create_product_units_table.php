<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->Increments('id');
            // ---------------------------------------------------------------------------
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            // ---------------------------------------------------------------------------
            $table->unsignedInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units');
            // ------------------------------------------------------------------------------
            // $table->unsignedInteger('family_attribute_option_id');
            // $table->foreign('family_attribute_option_id')->references('id')->on('family_attribute_options')->onDelete('cascade');
            // ------------------------------------------------------------------------------

            // $table->integer('purchase_price')->nullable();
            // $table->integer('rate')->nullable();
            // $table->float('cost')->nullable();
            // $table->integer('unit_type')->default(0)->nullable();


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
        Schema::dropIfExists('product_units');
    }
}
