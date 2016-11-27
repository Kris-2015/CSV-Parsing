<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert(array(
            'user_id' => '1',
            'resource' => 'page_1'
        ));

        DB::table('posts')->insert(array(
            'user_id' => '1',
            'resource' => 'movie'
        ));

        DB::table('posts')->insert(array(
            'user_id' => '1',
            'resource' => 'series'
        ));

        DB::table('posts')->insert(array(
            'user_id' => '1',
            'resource' => 'theme'
        ));
    }
}
