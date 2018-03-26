<?php


namespace Tests\Feature\Locations;


use App\Locations\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLocationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_locations_name_can_be_updated()
    {
        $this->disableExceptionHandling();
        $location = factory(Location::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'name' => 'UPDATED NAME',
            'address' => 'UPDATED ADDRESS'
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('store_locations', [
            'id' => $location->id,
            'name' => 'UPDATED NAME',
            'address' => 'UPDATED ADDRESS'
        ]);
    }

    /**
     *@test
     */
    public function the_name_is_required_to_update_the_location()
    {
        $location = factory(Location::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'name' => ''
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_address_field_is_required()
    {
        $location = factory(Location::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'address' => ''
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('address', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function the_name_must_be_under_255_characters()
    {
        $location = factory(Location::class)->create();

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'name' => str_repeat('X', 260)
        ]);
        $response->assertStatus(422);
        $this->assertArrayHasKey('name', $response->decodeResponseJson()['errors']);
    }

    /**
     *@test
     */
    public function only_the_name_and_address_will_be_updated()
    {
        $this->disableExceptionHandling();
        $location = factory(Location::class)->create([
            'name' => 'OLD NAME',
            'address' => 'OLD ADDRESS',
            'lat' => 33.33,
            'lng' => 66.66
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'name' => 'NEW NAME',
            'address' => 'NEW ADDRESS',
            'lat' => 44.44,
            'lng' => 77.77
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('store_locations', [
            'id' => $location->id,
            'name' => 'NEW NAME',
            'address' => 'NEW ADDRESS',
            'lat' => 33.33,
            'lng' => 66.66
        ]);
    }

    /**
     *@test
     */
    public function updating_successfully_responds_with_the_fresh_data()
    {
        $this->disableExceptionHandling();
        $location = factory(Location::class)->create([
            'name' => 'OLD NAME',
            'address' => 'OLD ADDRESS',
            'lat' => 33.33,
            'lng' => 66.66
        ]);

        $response = $this->asLoggedInUser()->json('POST', "/admin/locations/{$location->id}", [
            'name' => 'NEW NAME',
            'address' => 'NEW ADDRESS'
        ]);
        $response->assertStatus(200);

        $expected = [
            'id' => $location->id,
            'name' => 'NEW NAME',
            'address' => 'NEW ADDRESS',
            'lat' => 33.33,
            'lng' => 66.66
        ];

        $this->assertEquals($expected, $response->decodeResponseJson());
    }
}