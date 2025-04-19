<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Supplies', function (Blueprint $table) {
            $table->Increments('id');

            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            $table->unsignedInteger('daily_id')->nullable();
            $table->foreign('daily_id')->references('id')->on('dailies')->onDelete('cascade');

            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('note')->nullable();
            $table->string('supplier_name');
            $table->integer('grand_total');
            $table->string('status')->nullable();

            
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
        Schema::dropIfExists('Supplies');
    }
}
