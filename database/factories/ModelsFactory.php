<?php

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('password'),
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    $now = now();
    $countUser = User::all()->count();
    $countCategories = Category::all()->count();
    $userId = $faker->numberBetween(1, $countUser);
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

$factory->define(Tag::class, function (Faker $faker) {
    $tagName = $faker->word;

    return [
        'name' => $tagName
    ];
});

$factory->define(Comment::class, function (Faker $faker, array $arguments) {
    $countUser = User::all()->count();
    $userId = $faker->numberBetween(-25, $countUser); // -25 to 0: it is anonimus (chanse)
    
    if (isset($arguments['post_id'])) {
        $postId = $arguments['post_id'];
    } else {
        $countPost = Post::all()->count();
        $postId = $faker->numberBetween(1, $countPost);
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

$factory->define(Category::class, function (Faker $faker) {
    $categoryName = $faker->word;

    return [
        'name' => $categoryName
    ];
});
