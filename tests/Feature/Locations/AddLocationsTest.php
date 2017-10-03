<?php

namespace Tests\Feature\Locations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddLocationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_new_location_can_be_added()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
    }

    /**
     *@test
     */
    public function adding_a_new_location_responds_with_a_redirect_url()
    {
        $this->disableExceptionHandling();
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(200);

        $this->assertEquals(['redirect_url' => '/admin/locations'], $response->decodeResponseJson());
    }

    /**
     *@test
     */
    public function the_location_name_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => '',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_name_must_be_under_255_characters()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => str_repeat('X', 260),
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_address_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => '',
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('address', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_address_must_be_under_255_characters()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => str_repeat('X', 260),
            'lat' => 88.88888,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('address', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_latitude_value_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => '',
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lat', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_latitude_must_be_numeric()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 'NOT-A-NUMBER',
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lat', $response->decodeResponseJson()['errors']);
    }
    
    /**
     *@test
     */
    public function the_latitude_value_must_be_greater_than_negative_90()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => -95.00,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lat', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_latitude_must_be_less_than_90()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 95.00,
            'lng' => 33.33333
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lat', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_longitude_is_required()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 85.00,
            'lng' => ''
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lng', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_longitude_must_be_numeric()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 85.00,
            'lng' => 'NOT-A-NUMBER'
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lng', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_longitude_must_be_greater_than_negative_180()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 85.00,
            'lng' => -185.55
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lng', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_longitude_must_be_less_than_180()
    {
        $response = $this->asLoggedInUser()->json('POST', '/admin/locations', [
            'name' => 'TEST LOCATION NAME',
            'address' => 'TEST LOCATION ADDRESS',
            'lat' => 85.00,
            'lng' => 185.55
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('lng', $response->decodeResponseJson()['errors']);
    }
}