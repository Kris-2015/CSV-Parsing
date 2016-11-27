<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
           'name' => 'mafia boy',
            'email' => 'kris@black.com',
            'password' => bcrypt('kris@123')
        ));
    }
}
