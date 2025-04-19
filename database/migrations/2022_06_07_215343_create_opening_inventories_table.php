<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_inventuries', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');
            
            $table->unsignedInteger('unit_id')->unsigned()->nullable();
            $table->foreign('unit_id')->references('id')->on('units');

            $table->integer('qty')->default(0);

            // $table->integer('cost')->default(0);

            $table->integer('total')->default(0);

            // $table->date('expiry_date')->nullable();

            $table->date('date')->nullable();

        
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
        Schema::dropIfExists('opening_inventories');
    }
}
