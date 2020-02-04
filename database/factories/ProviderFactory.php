<?php

use App\Models\User;
use App\Models\Provider;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Provider::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'first_name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'suffix_type' => Arr::random(['md', 'phd', 'md-phd', 'rn', 'pa', 'np']),
	];
});