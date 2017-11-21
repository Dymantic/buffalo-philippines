<?php

namespace App\Http\Controllers;

use App\Locations\Location;
use Illuminate\Http\Request;

class StoreLocationsController extends Controller
{
    public function index()
    {
        $locations = Location::all()->map->toJsonableArray();

        return view('front.stores.page', ['locations' => $locations]);
    }
}
