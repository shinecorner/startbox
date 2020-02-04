<?php

use App\Models\Facility;
use App\Models\Location;
use App\Models\User;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\Provider;
use App\Models\Procedure;
use App\Models\Template;
use Faker\Generator as Faker;

$factory->define(Procedure::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'patient_id' => factory(Patient::class),
		'provider_id' => factory(Provider::class),
		'location_id' => factory(Location::class),
		'title' => $faker->catchPhrase,
		'description' => $faker->catchPhrase,
		'laterality' => rand(0,2),
		'script' => $faker->sentences(rand(2,4), true),
		'scheduled_at' => null,
		'archived_at' => null,
		'canceled_at' => null,
	];
});