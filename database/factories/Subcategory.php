<?php

use Faker\Generator as Faker;

$factory->define(\App\Products\Subcategory::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(\App\Products\Category::class)->create()->id;
        },
        'title'       => $faker->words(2, true),
        'description' => $faker->paragraph
    ];
});
