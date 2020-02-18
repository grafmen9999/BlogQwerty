<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker, array $arguments) {
    $now = now();
    $countCategories = Category::all()->count();
    if (isset($arguments['user_id'])) {
        $userId = $arguments['user_id'];
    } else {
        $countUser = User::all()->count();
        $userId = $faker->numberBetween(1, $countUser - 1);
    }

    $category = Category::find($faker->numberBetween(-10, $countCategories));
    
    return [
        'title' => $faker->word,
        'body' => $faker->text(400),
        'views' => $faker->numberBetween(0, 1000000),
        'user_id' => $userId,
        'category_id' => $category->id ?? null,
        'created_at' => $now,
        'updated_at' => $now
    ];
});
