<?php

namespace Tests\Controllers;

use Carbon\Carbon;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Faker\Generator;
use App\Models\Organization;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * POST 'api/register'
     */
    public function we_can_register_a_user()
    {
        $person = factory(User::class)->make();

        $response = $this->json('POST', '/client/api/v1/auth/register', [
                'first_name' => $person->first_name,
                'last_name' => $person->last_name,
                'email' => $person->email,
                'password' => $person->password,
                'organization_id' => $person->organization_id,
            ])
            ->assertJson(['success' => true])
            ->assertJsonFragment(['email' => $person->email])
            ->assertJsonStructure([
                'success',
                'data' => [
                    'token',
                    'user',
                ],
            ]);

        $this->assertCount(1, User::all());
    }
}