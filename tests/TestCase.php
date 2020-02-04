<?php

namespace Tests;

use Faker\Factory;

use App\Models\User;
use Laravel\Airlock\Airlock;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /***************************************************************************************
     ** HELPERS
     ***************************************************************************************/

    public function mockAdmin()
    {
        return factory(User::class)->states('admin')->create();
    }

    public function mockRegisteredUser()
    {
        $person = $this->mockRegistrant();
        $response = $this->json('POST', '/api/register', [
                            'first_name' => $person->first_name,
                            'last_name' => $person->last_name,
                            'email' => $person->email,
                            'password' => $person->password,
                        ])
                        ->assertJson(['success' => true])
                        ->assertJsonStructure([
                            'success',
                            'data' => [
                                'token',
                                'user',
                            ],
                        ]);
        return $person;
    }

    protected function mockRegistrant()
    {
        $faker = Factory::create();
        return (object) [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'password' => $faker->password,
        ];
    }

    public function authUser()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken('default');
        $user->withAccessToken($token);

        return $user;
    }

    public function spew()
    {
        $this->withoutExceptionHandling();
    }
}
