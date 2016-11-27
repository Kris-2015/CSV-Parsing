<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStackoverflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stackoverflow', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key of the table');
            $table->integer('emp_id')->comment('Foreign Key to the employee table');
            $table->integer('stack_id')->comment('Stack Over Flow Id');
            $table->string('stack_nickname')->comment('Stack Over Flow Name');
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
        Schema::dropIfExists('stackoverflow');
    }
}
