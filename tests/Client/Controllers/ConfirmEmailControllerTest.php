<?php

namespace Tests\Client\Controllers;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Events\EmailConfirmed;
use App\Models\EmailConfirmation;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ResendConfirmationEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * POST 'api/confirm-email'
     */
    public function a_user_can_confirm_an_email()
    {
        Event::fake();

        $user = factory(User::class)->create();

        $emailConfirmation = EmailConfirmation::makeOne($user);

        $this->json('POST', '/client/api/v1/confirm-email', [
            'email' => $user->email,
            'token' => $emailConfirmation->token,
        ])->assertJson(['success' => true]);

        Event::assertDispatched(EmailConfirmed::class);
        $this->assertTrue($user->fresh()->email_confirmed);
        $this->assertTrue($emailConfirmation->fresh()->confirmed);
    }

    /**
     * @test
     * POST 'api/request-confirm-email'
     */
    public function a_user_can_request_another_email_confirmation()
    {
        Bus::fake();

        $user = factory(User::class)->create();
        $emailConfirmation = EmailConfirmation::makeOne($user);
        $emailConfirmation->created_at = Carbon::now()->subMinutes(3);
        $emailConfirmation->save();

        $this->json('POST', '/client/api/v1/resend-confirm-email', [
            'email' => $user->email,
        ])->assertJson(['success' => true]);

        Bus::assertDispatched(ResendConfirmationEmail::class);
    }

    /**
     * @test
     * GET 'api/check-email-confirmed'
     */
    public function the_app_can_check_if_a_users_email_is_confirmed()
    {
        Event::fake();

        $user = factory(User::class)->create([
            'email_confirmed' => false,
            'token' => Str::random(8),
        ]);

       $this->actingAs($user)
            ->json('GET', '/client/api/v1/check-email-confirmed', [
                'email' => $user->email,
            ])->assertJson([
                'success' => true,
                'data' => [
                    'email_confirmed' => false,
                ],
            ]);

        $user->setEmailConfirmed();

        $this->actingAs($user)
            ->json('GET', '/client/api/v1/check-email-confirmed', [
                'email' => $user->email,
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'email_confirmed' => true,
                ],
            ]);
    }

    /**
     * @test
     * POST 'api/request-confirm-email'
     */
    public function a_user_has_to_wait_one_minute_to_get_an_email_confirmation()
    {
        $user = factory(User::class)->create([
            'email_confirmed' => false,
            'token' => Str::random(8),
        ]);

        $emailConfirmation = EmailConfirmation::makeOne($user);

        $this->json('POST', '/client/api/v1/resend-confirm-email', [
            'email' => $user->email,
        ])->assertJson([
            'success' => false,
            'error' => 'Please wait at least 1 minute before requesting another email.',
        ]);
    }

    /**
     * @test
     * POST 'api/resend-confirm-email'
     */
    public function a_user_cannot_request_an_email_confirmation_if_already_confirmed()
    {
        $user = factory(User::class)->create(['email_confirmed' => true]);

        $this->json('POST', '/client/api/v1/resend-confirm-email', [
            'email' => $user->email,
        ])->assertJson([
            'success' => false,
            'error' => 'The email address was already confirmed.',
        ]);
    }
}