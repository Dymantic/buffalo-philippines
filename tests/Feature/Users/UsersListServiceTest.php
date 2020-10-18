<?php


namespace Tests\Feature\Users;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersListServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_list_of_users_may_be_fetched()
    {
        $this->disableExceptionHandling();
        $users = collect([]);
        foreach(range(1,10) as $index) {
            $users->push($this->createUser(['name' => "Test User {$index}", 'email' => "test{$index}@example.com"]));
        }

        $response = $this->actingAs($users->first())->get('/admin/services/users');
        $response->assertStatus(200);

        $fetched_users = $response->json();

        $this->assertCount(10, $fetched_users);
        $users->each(function($user) use ($fetched_users) {
           $this->assertContains($user->toJsonableArray(), $fetched_users);
        });
    }
}