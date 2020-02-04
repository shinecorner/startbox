<?php

use App\Models\User;
use App\Models\Audit;
use App\Models\Facility;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Audit::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'title' => $faker->catchPhrase,
	];
});