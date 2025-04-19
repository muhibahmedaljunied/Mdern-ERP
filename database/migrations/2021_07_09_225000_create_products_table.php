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
            $table->Increments('id');


            // ---------------------------------------------------------------------------
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('products');
            // ------------------------------------------------------------------------------
            // $table->string('product_type');
            // ---------------------------------------------------------------------------------

            $table->string('text');
            $table->integer('rank')->nullable();
            $table->string('status')->default('true');

            $table->string('desc')->default('default');
            
            $table->integer('product_minimum')->nullable()->default(1);
            $table->string('image')->nullable();


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
