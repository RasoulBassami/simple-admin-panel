<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'post_id' => mt_rand(1,50),
        'image' => $faker->imageUrl(640, 480, 'animals', true),
        'alt' => $faker->sentence
    ];
});
