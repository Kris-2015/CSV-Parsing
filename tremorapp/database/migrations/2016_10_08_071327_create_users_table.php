<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration file for create user table
 *
 * @author: msfi-krishnadev
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('primary key of users table');
            $table->string('first_name', 50)->comment('first name');
            $table->string('last_name', 50)->comment('last name');
            $table->enum('gender', ['M', 'F', 'O'])->comment('M-Male, F-Female, O-Other');
            $table->char('pin', 4)->comment('Pin Number');
            $table->date('dob')->comment('Date of birth');
            $table->float('height', 5, 2)->comment('Height');
            $table->float('weight', 5, 2)->comment('Weight');
            $table->string('city', 50)->comment('City');
            $table->char('state', 2)->comment('State');
            $table->string('ethnicity', 50)->comment('Ethnicity');
            $table->tinyInteger('ET')->comment('Essential Tremor');
            $table->tinyInteger('PD')->comment('Parkinson Disease');
            $table->string('other', 50)->comment('Custom Tremor');
            $table->tinyInteger('tremor')->comment('0 - no tremor, 1 - tremor');
            $table->string('personal_email', 50)->comment('Personal Email id');
            $table->string('doctors_email', 50)->comment('Doctor Email id');
            $table->string('research_org_email', 50)->comment('Research Organisation Email');           
            $table->tinyInteger('test_complete')->default('0')->comment('0-test not completed, 1-test completed');
            $table->char('acceleration_unit', 2)->default('SI')->comment('International System of unit');
            $table->string('hash_key', 50)->comment('Hash Key');
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
        Schema::dropIfExists('users');
    }
}
