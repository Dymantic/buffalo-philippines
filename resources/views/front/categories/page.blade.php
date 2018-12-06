@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('title')
    Product Categories - BUFFALO® Tools
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Buffalo Tools Philippines - Our Tools',
        'ogImage' => url('/images/facebook_og.jpg'),
        'ogDescription' => 'Browse through all the different categories of tools we have to offer. No matter the job at hand, we have the tool you need.'
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg mb5 bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">Our Product Categories</h1>
    </header>
    <section class="flex flex-wrap justify-around contained center mv5">
        @foreach($categories as $category)
            <div class="ma3 w-40 mw-20-ns pa3 col-w-bg">
                <a href="/categories/{{ $category->slug }}" class="link col-d">
                    <img src="{{ $category->imageUrl('thumb') }}"
                         alt="Image for {{ $category->title }} category">
                    <p class="ff-title col-d hv-col-p">{{ $category->title }}</p>
                </a>
            </div>
        @endforeach
    </section>
@endsection