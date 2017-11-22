<?php

namespace Tests\Feature\Contact;

use App\Notifications\ContactMessageReceived;
use App\Secretary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendContactMessageTest extends TestCase
{
    use RefreshDatabase;

    private $secretary;

    public function setUp()
    {
        parent::setUp();

        Notification::fake();

        $this->secretary = app()->make(Secretary::class);
    }

    /**
     * @test
     */
    public function a_contact_message_can_be_posted_and_sent()
    {
        $this->disableExceptionHandling();

        $response = $this->json("POST", '/contact', [
            'name'    => 'TEST NAME',
            'email'   => 'test@email.con',
            'enquiry' => 'TEST ENQUIRY'
        ]);
        $response->assertStatus(200);

        Notification::assertSentTo(
            $this->secretary,
            ContactMessageReceived::class,
            function ($notification, $channels) {
                return $notification->message === [
                        'name'    => 'TEST NAME',
                        'email'   => 'test@email.con',
                        'enquiry' => 'TEST ENQUIRY'
                    ];
            });
    }

    /**
     *@test
     */
    public function the_contact_name_is_required()
    {
        $response = $this->json("POST", '/contact', [
            'name'    => '',
            'email'   => 'test@email.con',
            'enquiry' => 'TEST ENQUIRY'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('name', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_email_address_is_required()
    {
        $response = $this->json("POST", '/contact', [
            'name'    => 'TEST NAME',
            'email'   => '',
            'enquiry' => 'TEST ENQUIRY'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_email_ust_be_a_valid_address()
    {
        $response = $this->json("POST", '/contact', [
            'name'    => 'TEST NAME',
            'email'   => 'not-a-valid-email',
            'enquiry' => 'TEST ENQUIRY'
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('email', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_message_enquiry_is_required()
    {
        $response = $this->json("POST", '/contact', [
            'name'    => 'TEST NAME',
            'email'   => 'test@email.con',
            'enquiry' => ''
        ]);
        $response->assertStatus(422);

        $this->assertArrayHasKey('enquiry', $response->decodeResponseJson()['errors']);
    }
}