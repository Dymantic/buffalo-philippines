<?php


namespace Tests\Feature\Users;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_existing_user_can_be_updated()
    {
        $this->disableExceptionHandling();
        $user = $this->createUser([
            'name'  => 'OLD NAME',
            'email' => 'old@example.com'
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/users/{$user->id}", [
            'name'  => 'NEW NAME',
            'email' => 'new@example.com'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id'    => $user->id,
            'name'  => 'NEW NAME',
            'email' => 'new@example.com'
        ]);
    }

    /**
     * @test
     */
    public function updating_a_user_successfully_responds_with_the_fresh_data()
    {
        $this->disableExceptionHandling();
        $user = $this->createUser([
            'name'  => 'OLD NAME',
            'email' => 'old@example.com'
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/users/{$user->id}", [
            'name'  => 'NEW NAME',
            'email' => 'new@example.com'
        ]);
        $response->assertStatus(200);

        $expected = [
            'id'         => $user->id,
            'name'       => 'NEW NAME',
            'email'      => 'new@example.com',
            'superadmin' => true
        ];

        $this->assertEquals($expected, $response->json());
    }

    /**
     * @test
     */
    public function updating_a_user_requires_a_name()
    {
        $user = $this->createUser();

        $response = $this->asLoggedInUser()->json('POST', "/admin/users/{$user->id}", [
            'name'  => '',
            'email' => 'new@example.com'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('name', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function updating_a_user_requires_an_email_address()
    {
        $user = $this->createUser();

        $response = $this->asLoggedInUser()->json('POST', "/admin/users/{$user->id}", [
            'name'  => 'NEW NAME',
            'email' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->json()['errors']);
    }

    /**
     * @test
     */
    public function updating_a_user_requires_a_valid_email_address()
    {
        $user = $this->createUser();

        $response = $this->asLoggedInUser()->json('POST', "/admin/users/{$user->id}", [
            'name'  => 'NEW NAME',
            'email' => 'NOT-A-VALID-EMAIL'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->json()['errors']);
    }
}