<?php

use Faker\Generator as Faker;

$factory->define(\App\Products\Product::class, function (Faker $faker) {
    return [
        'title'       => $faker->words(3, true),
        'code'        => $faker->numberBetween(10000, 99999) . 'TEST',
        'description' => $faker->paragraph,
        'price'       => 'NT$' . $faker->numberBetween(1000, 9999),
        'writeup'     => $faker->paragraphs(2, true),
        'new_until'   => \Illuminate\Support\Carbon::parse('+1 month')
    ];
});
