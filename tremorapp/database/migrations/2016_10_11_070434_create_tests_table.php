<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration file for create tests table
 *
 * @author: msfi-krishnadev
 */
class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id')->comment('primary key of the tests table');
            $table->integer('user_id')->comment('foreign key of the users table');
            $table->index('user_id');
            $table->string('posture', 50)->comment('postural, kinetic, rest, brachy');
            $table->unique(['posture', 'user_id', 'ordinal']);
            $table->integer('ordinal')->comment('total number of test');
            $table->timestamp('start_time')->comment('Starting time of the test');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
