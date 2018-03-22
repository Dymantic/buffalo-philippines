@extends('front.base', ['pageName' => 'home-page'])

@section('content')
    <section class="col-d-bg"
             id="hero-banner">
        @foreach($banner_slides as $slide)
            @if($slide->is_video)
                @include("front.home.video-slide")
            @else
                @include("front.home.image-slide")
            @endif
        @endforeach
    </section>
    <section class="col-d-bg pv6 ph3 text-watermark-bg">
        <h3 class="tc ff-headline col-w ma0">Right Tools, Highest Performance</h3>
        <p class="col-w tc measure-wide lh-copy ff-large-body center">
            With over 200 quality products on offer, Buffalo Tools always has the right tool for the job. We believe that good tools can heighten a worker's professional performance and improve the quality of their daily work.
        </p>
        @include('front.partials.button-link', [
            'link' => '/about',
            'block' => true,
            'buttonText' => 'More About Us',
            'classes' => 'col-p'
        ])

    </section>
    @include('front.home.featured-products')
    <section class="col-d-bg pv6 ph3 location-watermark-bg">
        <h3 class="tc ff-headline col-w ma0">Locations</h3>
        <p class="ff-large-body col-w tc measure-wide lh-copy center">
            Are you looking for a specific hand tool? Let us help.<br>
            Buffalo products can be found in over 137 stores throughout the Philippines.
            We recommend you call the store first before visiting just to make sure they have what you’re looking for in stock.
        </p>
        @include('front.partials.button-link', [
            'link' => '/stores',
            'block' => true,
            'buttonText' => 'Find a Store',
            'classes' => 'col-p'
        ])
    </section>
    <section class="col-lg-bg pv6">
        <h3 class="tc ff-headline col-d ma0 mb5">News</h3>
        <div class="mw8 center-ns mh3 mv5">
            @foreach($articles as $article)
                @include('front.home.news-card')
            @endforeach
        </div>
        @include('front.partials.button-link', [
            'link' => '/news',
            'block' => true,
            'buttonText' => 'More News'
        ])
    </section>
@endsection

@section('bodyscripts')
    <script>
        var hero = new SuperHero('#hero-banner', 10000);
        hero.fly();
    </script>
@endsection