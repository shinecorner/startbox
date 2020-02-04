<?php

use App\Models\User;
use App\Models\Version;
use Faker\Generator as Faker;

$factory->define(Version::class, function (Faker $faker) {
    return [
		'title' => $faker->catchPhrase,
		'description' => $faker->catchPhrase,
		'severity' => $faker->catchPhrase,
		'build' => $faker->catchPhrase,
		'major' => 1,
		'minor' => rand(1, 99),
		'patch' => rand(1, 99),
	];
});