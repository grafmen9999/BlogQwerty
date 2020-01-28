<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text(),
        'user_id' => ($rand = $faker->numberBetween(-3, 50)) > 0 ? $rand : null,
        'post_id' => $faker->numberBetween(1, 50),
        'parent_id' => ($rand = $faker->numberBetween(-3, 30)) > 0 ? $rand : null,
    ];
});
