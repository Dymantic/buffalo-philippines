<?php


namespace Tests\Feature\Locations;


use App\Locations\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteLocationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *@test
     */
    public function a_location_may_be_deleted()
    {
        $this->disableExceptionHandling();
        $location = factory(Location::class)->create();

        $response = $this->asLoggedInUser()->json('DELETE', "/admin/locations/{$location->id}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }
}