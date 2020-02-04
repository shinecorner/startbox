<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'organization_id' => factory(Organization::class),
        'facility_id' => factory(Facility::class),
        'title' => $faker->company,
        'description' => $faker->paragraph(),
        'longitude' => $faker->longitude(),
        'latitude' => $faker->latitude(),
    ];
});
