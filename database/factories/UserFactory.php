<?php

use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Str;
use App\Models\Organization;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;
    return [
        'organization_id' => factory(Organization::class),
        'profileable_type' => Provider::class,
        'profileable_id' => factory(Provider::class),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'token' => Str::random(20),
        'sso_id' => Str::random(20),
    ];
});

// state: no-profile
$factory->state(App\Models\User::class, 'no-profile', function (Faker $faker) {
    return [
        'profileable_type' => null,
        'profileable_id' => null,
    ];
});

// state: admin
$factory->state(App\Models\User::class, 'admin', function (Faker $faker) {
    return [
        'is_admin' => true,
    ];
});

// state: provider
$factory->state(App\Models\User::class, 'provider', function (Faker $faker) {
    return [
        'profileable_id' => function (array $user) {
            return factory(App\Models\Provider::class)->create()->id;
        },
    ];
});
$factory->afterMakingState(App\Models\User::class, 'provider', function ($user, $faker) {
    $user->profileable->attach($user->organization);
});
