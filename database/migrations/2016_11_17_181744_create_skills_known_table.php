<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsKnownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills_known', function (Blueprint $table) {
            $table->increments('id')->comment('Primary Key of the table');
            $table->integer('skill_id')->comment('Foreign Key to the skills table');
            $table->integer('emp_id')->comment('Foreign Key to the employees table');
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
        Schema::dropIfExists('skills_known');
    }
}
