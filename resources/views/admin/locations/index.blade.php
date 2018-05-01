@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Store Locations</h1>
        <div class="flex justify-end items-center">
            <a class="btn" href="/admin/locations/create">Add Location</a>
        </div>
    </div>
    <div>
        <location-index :list='{{ json_encode($locations->map->toJsonableArray())  }}'></location-index>
    </div>
@endsection