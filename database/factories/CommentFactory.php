<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker, array $arguments) {
    $countUser = User::all()->count();
    $userId = $faker->numberBetween(-25, $countUser); // -25 to 0: it is anonimus (chanse)
    
    if (isset($arguments['post_id'])) {
        $postId = $arguments['post_id'];
    } else {
        $countPost = Post::all()->count();
        $postId = $faker->numberBetween(1, $countPost - 1);
    }

    $parentId = null;

    if ($faker->numberBetween(25, 100) >= 50) {
        $parentId = factory(Comment::class)->create([
            'post_id' => $postId
        ])->id;
    }

    // Log::log('debug', 'parent_id: ' . $parentId ?? "null");

    return [
        'body' => $faker->text(),
        'user_id' => ($userId) > 0 ? $userId : null, // anonimus
        'post_id' => $postId,
        'parent_id' => $parentId,
    ];
});
