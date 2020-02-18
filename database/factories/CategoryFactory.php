<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $categoryName = $faker->unique()->word;

    return [
        'name' => $categoryName
    ];
});
