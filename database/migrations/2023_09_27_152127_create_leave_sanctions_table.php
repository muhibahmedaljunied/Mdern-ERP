<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
class CreateLeaveSanctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_sanctions', function (Blueprint $table) {

            $table->Increments('id');

            $table->unsignedInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');

            $table->unsignedInteger('part_id');
            $table->foreign('part_id')->references('id')->on('parts');

            $table->unsignedInteger('sanction_discount_id');
            $table->foreign('sanction_discount_id')->references('id')->on('sanction_discounts');

            $table->integer('discount');

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
        Schema::dropIfExists('leave_sanctions');
    }
}
