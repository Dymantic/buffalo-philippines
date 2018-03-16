<?php

namespace App\Http\Controllers\Admin;

use App\Locations\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{

    public function index()
    {
        return view('admin.locations.index', ['locations' => Location::all()]);
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store()
    {
        request()->validate([
            'name'    => 'required|max:255',
            'address' => 'required|max:255',
            'lat'     => 'required|numeric|between:-90,90',
            'lng'     => 'required|numeric|between:-180,180'
        ]);
        Location::create(request()->all());

        return ['redirect_url' => '/admin/locations'];
    }

    public function update(Location $location)
    {
        request()->validate([
            'name' => 'required|max:255',
            'address' => 'required'
        ]);

        $location->update(request(['name', 'address']));

        return $location->fresh()->toJsonableArray();
    }

    public function delete(Location $location)
    {
        $location->delete();
    }
}
