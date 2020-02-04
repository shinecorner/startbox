<?php

use App\Models\User;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\Facility;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
        'default_provider_id' => factory(Provider::class),
		'dod_identifier' => $faker->catchPhrase,
		'first_name' => $faker->catchPhrase,
		'last_name' => $faker->catchPhrase,
		'sex' => Arr::random(['m', 'f', '0']),
		'dob' => now()->subYears(rand(20, 30))->subDays(rand(2, 200))->toDateString(),
	];
});