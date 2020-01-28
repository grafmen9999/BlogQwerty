<?php

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class CommentsTableSeeder
 */
class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(Comment::class, 1000)->create();
        DB::table('comments')->insert([
            'body' => 'Comment 1 [block 1]',
            'post_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('comments')->insert([
            'body' => 'Comment 2 [block 1]',
            'post_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('comments')->insert([
            'body' => 'Comment 3 [block 2] {Comment 1}',
            'post_id' => 1,
            'parent_id' => 1,
            'user_id' => 3,
        ]);

        DB::table('comments')->insert([
            'body' => 'Comment 3 [block 3] {Comment 1}',
            'post_id' => 1,
            'parent_id' => 3,
            'user_id' => 1,
        ]);
    }
}
