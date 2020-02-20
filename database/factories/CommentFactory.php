<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker, array $arguments) {
    $users = User::all();
    
    $userId = ($faker->boolean() &&
            $users->first() !== null &&
            $users->last() !== null) ?
        $faker->numberBetween($users->first()->id, $users->last()->id) : null;
    
    if (isset($arguments['post_id'])) {
        $postId = $arguments['post_id'];
    } else {
        $posts = Post::all();
        $postId = $faker->numberBetween($posts->first()->id, $posts->last()->id);
    }

    $parentId = null;

    if ($faker->boolean()) {
        $parentId = factory(Comment::class)->create([
            'post_id' => $postId
        ])->id;
    }
    
    return [
        'body' => $faker->text(),
        'user_id' => ($userId) > 0 ? $userId : null, // anonimus
        'post_id' => $postId,
        'parent_id' => $parentId,
    ];
});
