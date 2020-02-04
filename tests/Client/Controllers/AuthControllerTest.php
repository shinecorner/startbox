<?php

namespace Tests\Client\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Arr;
use GuzzleHttp\Psr7\Request;
use Laravel\Airlock\Airlock;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * POST /api/auth/login
     */
    public function a_user_can_login_with_email()
    {
        $user = factory(User::class)->create();

        $response = $this->json('POST', '/client/api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ])->assertJson([
            'success' => true,
        ])->decodeResponseJson();

        $tokenPlain = Arr::get($response, 'data.token');
        $tokenHash = hash('sha256', $tokenPlain);

        $this->assertTrue(is_string($tokenPlain));
        $this->assertCount(1, $user->tokens);
        $this->assertEquals($tokenHash, $user->tokens->first()->token);
    }

    /**
     * @test
     * GET /api/auth/refresh
     */
    public function a_user_can_refresh_login_token()
    {
        $user = factory(User::class)->create();
        $oldToken = $user->createToken('default');
        $oldTokenModel = $oldToken->accessToken;
        $oldTokenPlain = $oldToken->plainTextToken;

        $response = $this->withHeaders(['Authorization' => "Bearer {$oldTokenPlain}"])
            ->post('client/api/v1/auth/refresh')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['token']])
            ->decodeResponseJson();

        $newTokenPlain = Arr::get($response, 'data.token');
        $newTokenHash = hash('sha256', $newTokenPlain);

        $this->assertNotNull($newTokenPlain);
        $this->assertTrue(is_string($newTokenPlain));
        $this->assertNotEquals($newTokenPlain, $oldTokenPlain);
        $this->assertCount(1, $user->tokens);
        $this->assertEquals($newTokenHash, $user->tokens->first()->token);
        $this->assertNotNull($oldTokenModel);
        $this->assertNull($oldTokenModel->fresh());

        // TODO: Waiting on a airlock feature request
        // $this->withHeaders(['Authorization' => "Bearer {$newTokenPlain}"])->get('api/user')->assertSuccessful();
        // $this->withHeaders(['Authorization' => "Bearer {$oldTokenPlain}"])->get('api/user')->assertUnauthorized();
    }

    /**
     * @test
     * GET 'api/user'
     */
    public function the_app_can_get_the_current_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user, 'airlock')
            ->json('GET', '/client/api/v1/user')
            ->assertJson(['success' => true])
            ->assertJsonFragment(['token' => $user->token]);
    }

    /**
     * @test
     * GET /api/auth/logout
     */
    public function a_user_can_logout()
    {
        $user = factory(User::class)->create();

        $token = $user->createToken('default')->plainTextToken;

        $this->withHeaders(['Authorization' => "Bearer {$token}"])
            ->json('POST', 'client/api/v1/auth/logout')
            ->assertSuccessful();

        $this->assertCount(0, $user->fresh()->tokens);

        // TODO: Waiting on a airlock feature request
        // $this->withHeaders(['Authorization' => "Bearer {$token}"])
        //     ->json('GET', 'api/status')
        //     ->assertUnauthorized();
    }

    /**
     * @test
     * GET 'api/users/password-is-valid'
     */
    public function a_valid_password_returns_true()
    {
        $response = $this->json('GET', 'client/api/v1/auth/password-is-valid', [
            'password' => 'thisIsMinLength',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * @test
     * GET 'api/users/password-is-valid'
     */
    public function an_invalid_password_returns_an_error()
    {
        $response = $this->json('GET', '/client/api/v1/auth/password-is-valid', [
            'password' => 'this',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error' => 'Your password must be a minimum of 6 characters',
            ]);
    }

    /**
     * @test
     * GET 'api/users/email-is-unique'
     */
    public function a_unique_email_returns_true()
    {
        $response = $this->json('GET', '/client/api/v1/auth/email-is-unique', [
            'email' => $this->faker->unique()->email,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * @test
     * GET 'api/users/email-is-unique'
     */
    public function a_used_email_return_an_error()
    {
        $user = factory(User::class)->create();

        $response = $this->json('GET', '/client/api/v1/auth/email-is-unique', [
            'email' => $user->email,
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'error' => 'There is already an account with this email'
            ]);
    }
}
