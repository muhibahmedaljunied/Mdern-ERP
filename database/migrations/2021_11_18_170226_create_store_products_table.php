<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_products', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->unsignedInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            // $table->unsignedInteger('family_attribute_option_id')->unsigned()->nullable();
            // $table->foreign('family_attribute_option_id')->references('id')->on('family_attribute_options');

            $table->unsignedInteger('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('stores');

            $table->unsignedInteger('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('statuses');
            
            $table->string('desc')->default('default');

            $table->string('image')->nullable();

            $table->string('qr_code')->nullable();

            $table->integer('quantity')->default(0);

            $table->float('cost')->default(0);

            $table->float('total')->default(0);

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
        Schema::dropIfExists('store_products');
    }
}
