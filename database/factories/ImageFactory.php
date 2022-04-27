<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'post_id' => mt_rand(1,50),
        'path' => $faker->imageUrl(640, 480, 'animals', true),
        'name' => $faker->word()
    ];
});
