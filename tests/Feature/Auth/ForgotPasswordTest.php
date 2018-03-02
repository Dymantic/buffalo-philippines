<?php


namespace Tests\Feature\Auth;


use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_password_reset_email_is_sent_to_a_valid_user()
    {
        $this->disableExceptionHandling();
        Notification::fake();

        $user = $this->createUser(['email' => 'test@example.com']);

        $response = $this->post(route('password.email'), ['email' => 'test@example.com']);
        $response->assertStatus(302);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}