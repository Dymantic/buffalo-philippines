<?php

namespace Tests\Unit\Locations;

use App\Locations\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_location_can_be_presented_as_a_jsonable_array()
    {
        $location = factory(Location::class)->create([
            'name'    => 'TEST NAME',
            'address' => 'TEST ADDRESS',
            'lat'     => 33.33,
            'lng'     => 66.66
        ]);

        $expected = [
            'id'      => $location->id,
            'name'    => 'TEST NAME',
            'address' => 'TEST ADDRESS',
            'lat'     => 33.33,
            'lng'     => 66.66
        ];

        $this->assertEquals($expected, $location->toJsonableArray());
    }
}