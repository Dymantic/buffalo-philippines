<?php

use Faker\Generator as Faker;

$factory->define(\App\Products\Category::class, function (Faker $faker) {
    return [
        'title'       => $faker->words(2, true),
        'description' => $faker->paragraph
    ];
});
