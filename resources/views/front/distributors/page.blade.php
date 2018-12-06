@extends('front.base', ['pageName' => ''])

@section('title')
    Buffalo Tools - Become a Distributor
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Buffalo Tools - Become a Distributor',
        'ogImage' => url('/images/facebook_og.jpg'),
        'ogDescription' => 'Would you like to become a Buffalo distributor? Success is guaranteed.'
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">Become a Distributor</h1>
    </header>
    @include('front.distributors.banner')
    @include('front.distributors.map')
    @include('front.distributors.benefits')

    @include('front.distributors.form')
@endsection