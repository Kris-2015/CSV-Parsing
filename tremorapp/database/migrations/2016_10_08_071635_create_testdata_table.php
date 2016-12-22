<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration file for create test data table
 *
 * @author: msfi-krishnadev
 */
class CreateTestDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_data', function (Blueprint $table) {
            $table->increments('id')->comment('primary key of the test_data');
            $table->integer('test_id')->comment('foreign key of the test table');
            $table->index('test_id');
            $table->float('accel_x', 5, 2)->comment('acceleration data in x-axis direction');
            $table->float('accel_y', 5, 2)->comment('acceleration data in y-axis direction');
            $table->float('accel_z', 5, 2)->comment('acceleration data in z-axis direction');
            $table->integer('t')->comment('time in macro second');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_data');
    }
}
