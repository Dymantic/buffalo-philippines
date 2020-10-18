<?php


namespace Tests\Feature\Users;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_valid_user_may_be_created()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test Name',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name'       => 'Test Name',
            'email'      => 'test@example.com',
            'superadmin' => true
        ]);
    }

    /**
     * @test
     */
    public function a_non_superadmin_is_still_a_valid_user()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test Name',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => '',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name'       => 'Test Name',
            'email'      => 'test@example.com',
            'superadmin' => false
        ]);
    }

    /**
     * @test
     */
    public function a_user_is_created_with_a_hashed_password()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test Name',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(200);

        $new_user = User::where('email', 'test@example.com')->first();
        $this->assertNotEquals('password', $new_user->password);
        $this->assertTrue(Hash::check('password', $new_user->password));
    }

    /**
     * @test
     */
    public function a_new_user_requires_a_name()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => '',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('name', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_user_name_must_be_under_255_characters()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => str_repeat('x', 256),
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('name', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_users_email_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test name',
            'email'                 => '',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_users_email_must_be_a_valid_email_address()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test name',
            'email'                 => 'NOT_A_VALID_EMAIL',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_new_users_password_must_be_at_least_8_characters_long()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test name',
            'email'                 => 'test@example.com',
            'password'              => 'short',
            'password_confirmation' => 'short',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('password', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function the_users_password_must_have_a_matching_confirmation()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/users', [
            'name'                  => 'Test name',
            'email'                 => 'test@example.com',
            'password'              => 'GOOD-PASSWORD',
            'password_confirmation' => 'BAD-PASSWORD',
            'superadmin'            => true
        ]);

        $response->assertStatus(422);

        $this->assertArrayHasKey('password', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function a_user_can_only_be_created_by_another_logged_in_user()
    {
        $response = $this->json('POST', '/admin/users', [
            'name'                  => 'Test Name',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
            'superadmin'            => true
        ]);

        $response->assertStatus(401);

        $this->assertDatabaseMissing('users', [
            'name'       => 'Test Name',
            'email'      => 'test@example.com',
            'superadmin' => true
        ]);
    }
}