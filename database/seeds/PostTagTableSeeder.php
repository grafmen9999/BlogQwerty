<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for ($i = 0; $i < 70; $i++) {
        //     DB::table('post_tag')->insert([
        //         'post_id' => random_int(1, 50),
        //         'tag_id' => random_int(1, 10),
        //     ]);
        // }

        DB::table('post_tag')->insert([
            'post_id' => 1,
            'tag_id' => 1,
        ]);
        DB::table('post_tag')->insert([
            'post_id' => 1,
            'tag_id' => 2,
        ]);
        
        DB::table('post_tag')->insert([
            'post_id' => 2,
            'tag_id' => 2,
        ]);
        DB::table('post_tag')->insert([
            'post_id' => 2,
            'tag_id' => 3,
        ]);
    }
}
