@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Add a new location</h1>
        <div class="flex justify-end items-center">
            <a href="/admin/locations"
               class="btn">Back</a>
        </div>
    </div>
    <location-finder></location-finder>

@endsection

@section('bodyscripts')
    <script>
        function initMap() {
            eventHub.$emit('maps-loaded');
        }
    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.key') }}&libraries=places&callback=initMap"></script>
@endsection