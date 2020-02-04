<?php

use App\Models\User;
use App\Models\Activity;
use App\Models\Facility;
use App\Models\Procedure;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'subject_id' => factory(Procedure::class),
		'subject_type' => Procedure::class,
		'display' => $faker->catchPhrase,
	];
});