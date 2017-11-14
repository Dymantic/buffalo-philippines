<?php

use Faker\Generator as Faker;

$factory->define(\App\Products\ToolGroup::class, function (Faker $faker) {
    return [
        'subcategory_id' => function () {
            return factory(\App\Products\Subcategory::class)->create()->id;
        },
        'title'       => $faker->words(2, true),
        'description' => $faker->paragraph
    ];
});
