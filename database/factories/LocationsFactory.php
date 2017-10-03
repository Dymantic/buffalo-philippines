<?php

use Faker\Generator as Faker;

$factory->define(\App\Locations\Location::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'lat' => $faker->numberBetween(1527,1816) / 100,
        'lng' => $faker->numberBetween(12057,12132) / 100,
    ];
});
