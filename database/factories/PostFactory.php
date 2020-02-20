<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker, array $arguments) {
    $now = now();
    if (isset($arguments['user_id'])) {
        $userId = $arguments['user_id'];
    } else {
        $users = User::all();
        $userId = $faker->numberBetween($users->first()->id, $users->last()->id);
    }
    
    $categories = Category::all();
    
    $categoryId = ($faker->boolean() &&
            $categories->first() !== null &&
            $categories->last() !== null) ?
            $faker->numberBetween($categories->first()->id,$categories->last()->id) : null;
    
    return [
        'title' => $faker->word,
        'body' => $faker->text(400),
        'views' => $faker->numberBetween(0, 1000000),
        'user_id' => $userId,
        'category_id' => $categoryId,
        'created_at' => $now,
        'updated_at' => $now
    ];
});
