<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('staff');
            $table->date('attendance_date');
            $table->string('attendance_status');
            $table->string('attendance_final');
            // $table->time('check_in')->nullable();
            // $table->time('check_out')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
