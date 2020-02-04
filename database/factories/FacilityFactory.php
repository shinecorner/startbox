<?php

use App\Models\User;
use App\Models\Facility;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Facility::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'title' => $faker->catchPhrase,
		'description' => $faker->catchPhrase,
		'timezone' => $faker->catchPhrase,
	];
});