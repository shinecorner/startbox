<?php

use App\Models\User;
use App\Models\Login;
use App\Models\Facility;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Login::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'user_id' => factory(User::class),
		'agent' => $faker->catchPhrase,
	];
});