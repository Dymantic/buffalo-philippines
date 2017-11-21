@extends('front.base', ['pageName' => 'home-page'])

@section('content')
    <section class=""
             data-flickity>
        @foreach($banner_slides as $slide)
            @if($slide->is_ideo)
                @include("front.home.video-slide")
            @else
                @include("front.home.image-slide")
            @endif
        @endforeach
    </section>
    <section class="col-d-bg pv6">
        <h3 class="tc ttu strong-type col-w ma0 f1">The Right Tools For You</h3>
        <p class="f3 col-w tc measure-wide lh-copy body-type center">
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
        <h3 class="tc ttu strong-type col-w ma0 f1">Locations</h3>
        <p class="f3 col-w tc measure-wide lh-copy body-type center">
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
        <h3 class="tc ttu strong-type col-d ma0 f1 mb5">News</h3>
        <div class="mw8 flex justify-around center mv5">
            @foreach(range(1,4) as $item)
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