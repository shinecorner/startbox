<?php

use App\Models\User;
use App\Models\Facility;
use App\Models\Template;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Template::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'title' => $faker->catchPhrase,
		'description' => $faker->catchPhrase,
		'script' => $faker->text,
	];
});