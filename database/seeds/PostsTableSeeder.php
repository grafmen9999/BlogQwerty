<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

/**
 * Class PostsTableSeeder
 */
class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 15)
        ->create()
        // for fill tags
        ->each(function ($post) {
            $tags = Tag::all();
            $countTags = $tags->count();
            $countTagsForPost = random_int(0, $countTags - 1);
            $currentTagsForPost = $post->tags()->get();

            while ($countTagsForPost-- > 0) {
                $randomKey = random_int(0, $countTags - 1);
                $tag = $tags[$randomKey];

                $filters = $currentTagsForPost->filter(function ($item) use ($tag) {
                    return $item->id === $tag->id;
                });

                if ($filters->count() > 0) {
                    $countTagsForPost++;
                    continue;
                }
            
                $post->tags()->save($tag);
                $currentTagsForPost->push($tag);
            }
        });
    }
}
