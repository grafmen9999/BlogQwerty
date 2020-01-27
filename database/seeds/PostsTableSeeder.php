<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Post::class, 50)->create();

        DB::table('posts')->insert([
            'title' => 'Post 1',
            'body' => 'Body post 1',
            'user_id' => 1,
            'views' => 155
        ]);

        DB::table('posts')->insert([
            'title' => 'Post 2',
            'body' => 'Body post 2',
            'user_id' => 2,
            'views' => 33
        ]);
    }
}
