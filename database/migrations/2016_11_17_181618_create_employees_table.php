<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key of the table');
            $table->string('emp_id')->comment('Employee Id');
            $table->string('first_name', 50)->comment('First Name');
            $table->string('last_name', 50)->comment('Last Name');
            $table->string('created_by', 50)->comment('Created by');
            $table->string('updated_by', 50)->comment('Updated by');
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
        Schema::dropIfExists('employees');
    }
}
