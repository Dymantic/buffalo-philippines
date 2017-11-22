@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb0 h4 flex items-center justify-center tc">
        <h1 class="strong-type f1">Find A Buffalo Stockist</h1>
    </header>
    <store-locator :locations='{{ json_encode($locations) }}'></store-locator>
@endsection

@section('bodyscripts')
    <script>
        function initMap() {
            eventHub.$emit('maps-loaded');
        }
    </script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.key') }}&callback=initMap"></script>
@endsection