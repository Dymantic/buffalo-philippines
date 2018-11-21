<?php

namespace Tests\Feature\Distributors;

use App\DistributorApplicationMessage;
use Dymantic\Secretary\ContactMessage;
use Dymantic\Secretary\Message;
use Dymantic\Secretary\MessageReceived;
use Dymantic\Secretary\Secretary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class DistributorApplicationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function an_application_to_be_a_distributor_may_be_supplied()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $response = $this->asLoggedInUser()->postJson('/distributors/applications', [
            'name' => 'Test name',
            'email' => 'test@test.test',
            'country' => 'Test Country',
            'application_message' => 'Test message'
        ]);

        $response->assertStatus(200);

        Notification::assertSentTo([app()->make(Secretary::class)], MessageReceived::class,  function($notification, $channels) {
            return $notification->message->sender() === 'Test name';
        });
    }
}