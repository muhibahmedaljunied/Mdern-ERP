<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateExtraSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_sanctions', function (Blueprint $table) {

            $table->Increments('id');


            $table->unsignedInteger('extra_type_id');
            $table->foreign('extra_type_id')->references('id')->on('extra_types');

            $table->unsignedInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts');

            $table->unsignedInteger('sanction_discount_id');
            $table->foreign('sanction_discount_id')->references('id')->on('sanction_discounts');


            $table->integer('iteration');


            $table->integer('sanction');

       
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
        Schema::dropIfExists('extra_sanctions');
    }
}
