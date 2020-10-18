<?php


namespace Tests\Feature\Users;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_logged_in_user_may_reset_their_own_password()
    {
        $this->disableExceptionHandling();
        $user = $this->createUser(['password' => 'password'], true);
        $this->actingAs($user);

        $response = $this->json("POST", "/admin/me/password", [
            'current_password'      => 'password',
            'password'              => 'secretly',
            'password_confirmation' => 'secretly'
        ]);
        $response->assertStatus(200);

        $this->assertTrue(Hash::check('secretly', $user->fresh()->password));
    }

    /**
     *@test
     */
    public function the_current_password_must_pass_the_hash_check_against_logged_in_users_password()
    {
        $user = $this->createUser(['password' => 'password'], true);
        $this->actingAs($user);

        $response = $this->json("POST", "/admin/me/password", [
            'current_password'      => 'THIS_AINT_RIGHT',
            'password'              => 'new-password',
            'password_confirmation' => 'new-password'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('current_password', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_new_password_must_be_at_least_8_characters_long()
    {
        $user = $this->createUser(['password' => 'password'], true);
        $this->actingAs($user);

        $response = $this->json("POST", "/admin/me/password", [
            'current_password'      => 'password',
            'password'              => 'short',
            'password_confirmation' => 'short'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('password', $response->json()['errors']);
    }

    /**
     *@test
     */
    public function the_new_password_must_have_a_matching_confirmation()
    {
        $user = $this->createUser(['password' => 'password'], true);
        $this->actingAs($user);

        $response = $this->json("POST", "/admin/me/password", [
            'current_password'      => 'password',
            'password'              => 'good-password',
            'password_confirmation' => 'DOES_NOT_MATCH'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('password', $response->json()['errors']);
    }
}