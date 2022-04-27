<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => mt_rand(1,2),
        'title' => $faker->unique()->sentence,
        'description' => $faker->paragraph(1),
        'body' => $faker->text($maxNbChars = 300),
        'is_active' => mt_rand(0,1)
    ];
});
