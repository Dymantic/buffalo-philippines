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
    <section class="col-d-bg pv6">
        <h3 class="tc ff-headline col-w ma0">The Right Tools For You</h3>
        <p class="col-w tc measure-wide lh-copy ff-large-body center">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium asperiores debitis deserunt ducimus
            excepturi itaque iure minus officia optio, quod quos ratione sitsuscipit tempora unde? Dolore laborum
            molestias nam!
        </p>
        @include('front.partials.button-link', [
            'link' => '/stores',
            'block' => true,
            'buttonText' => 'More About Us',
            'classes' => 'col-p'
        ])

    </section>
    @include('front.home.featured-products')
    <section class="col-d-bg pv6">
        <h3 class="tc ff-headline col-w ma0">Locations</h3>
        <p class="ff-large-body col-w tc measure-wide lh-copy center">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium asperiores debitis deserunt ducimus
            excepturi itaque iure minus officia optio, quod quos ratione sit suscipit tempora unde? Dolore laborum
            molestias nam!
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
        var hero = new SuperHero('#hero-banner', 8000);
        hero.fly();
    </script>
@endsection