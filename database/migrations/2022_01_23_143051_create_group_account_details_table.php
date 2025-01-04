<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupAccountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::connection('mysql2')->create('some_table', function($table)
        Schema::create('group_account_details', function (Blueprint $table) {

            $table->Increments('id');

      
            $table->unsignedInteger('group_account_id')->nullable();
            $table->foreign('group_account_id')->references('id')->on('group_accounts');

            $table->unsignedInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');

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
        Schema::dropIfExists('group_account_details');
    }
}
