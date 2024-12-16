<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupAccountDailyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::connection('mysql2')->create('some_table', function($table)
        Schema::create('group_account_daily_details', function (Blueprint $table) {

            $table->Increments('id');

             $table->morphs('dailyable');

            $table->unsignedInteger('daily_detail_id')->nullable();
            $table->foreign('daily_detail_id')->references('id')->on('daily_details');

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
        Schema::dropIfExists('group_account_daily_details');
    }
}
