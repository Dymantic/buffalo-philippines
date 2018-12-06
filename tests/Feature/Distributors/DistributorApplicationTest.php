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
     * @test
     */
    public function an_application_to_be_a_distributor_may_be_supplied()
    {
        $this->withoutExceptionHandling();
        Notification::fake();

        $response = $this->asLoggedInUser()->postJson('/distributors/applications', $this->validDefaults());

        $response->assertStatus(200);

        Notification::assertSentTo([app()->make(Secretary::class)], MessageReceived::class,
            function ($notification, $channels) {
                $provided = $this->validDefaults();
                $message_data = $notification->message->data;
                foreach($provided as $field => $value) {
                    if($message_data[$field] !== $value) {
                        return false;
                    }
                }
                return true;
            });
    }

    /**
     * @test
     */
    public function the_name_is_required()
    {
        $response = $this->asLoggedInUser()->postJson('/distributors/applications',
            $this->validDefaults(['name' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    /**
     *@test
     */
    public function the_email_is_required()
    {
        $response = $this->asLoggedInUser()->postJson('/distributors/applications',
            $this->validDefaults(['email' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     *@test
     */
    public function the_email_must_be_a_valid_address()
    {
        $response = $this->asLoggedInUser()->postJson('/distributors/applications',
            $this->validDefaults(['email' => 'not-a-valid-email']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /**
     *@test
     */
    public function the_application_message_is_required()
    {
        $response = $this->asLoggedInUser()->postJson('/distributors/applications',
            $this->validDefaults(['application_message' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('application_message');
    }

    private function validDefaults($overrides = [])
    {
        $defaults = [
            'name'                => 'Test name',
            'email'               => 'test@test.test',
            'country'             => 'Test country',
            'company'             => 'Test company',
            'website'             => 'https://test.test',
            'application_message' => 'Test inquiry',
            'referrer'            => 'Test referrer'
        ];

        return array_merge($defaults, $overrides);
    }


}