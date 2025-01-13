<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::connection('mysql2')->create('some_table', function($table)
        Schema::create('groups', function (Blueprint $table) {



            $table->Increments('id');
            $table->string('name');
            $table->unsignedInteger('group_type_id')->nullable();
            $table->foreign('group_type_id')->references('id')->on('group_types');
            $table->string('code')->nullable();

            $table->string('status')->default(0);
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
        Schema::dropIfExists('groups');
    }
}
