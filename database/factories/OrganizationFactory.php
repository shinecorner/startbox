<?php

use Faker\Generator as Faker;
use App\Models\Organization;

$factory->define(Organization::class, function (Faker $faker) {
    return [
		'title' => $faker->catchPhrase,
		'description' => $faker->catchPhrase,
	];
});