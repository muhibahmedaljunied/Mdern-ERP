<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_details', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('transfer_id');
            $table->foreign('transfer_id')->references('id')->on('transfers');

            $table->unsignedInteger('store_product_id');
            $table->foreign('store_product_id')->references('id')->on('store_products');

            $table->text('into_store');
            $table->text('from_store');

            $table->integer('qty');
          
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
        Schema::dropIfExists('transfer_details');
    }
}
