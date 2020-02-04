<?php

use App\Models\User;
use App\Models\Comment;
use App\Models\Facility;
use App\Models\Procedure;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
		'organization_id' => factory(Organization::class),
		'facility_id' => factory(Facility::class),
		'commentable_id' => factory(Procedure::class),
		'commentable_type' => Procedure::class,
		'body' => $faker->text,
	];
});