@extends('front.base')

@section('content')
    {{--<header class="banner-heading mesh-bg bb bw2 mb4 h4 flex items-center justify-center tc">--}}
        {{--<h1 class="strong-type f1">{{ $product['title'] }}</h1>--}}
    {{--</header>--}}
    <section class="mt5 mw8 center-ns mh3 flex justify-between">
        <div class="w-50 pa4">
            <img src="{{ $product['main_image']['web'] }}"
                 alt="Product image of {{ $product['title'] }}">
            <div>
                @foreach($product['gallery_images'] as $gallery_image)
                    <img src="{{ $gallery_image['thumb'] }}"
                         alt="Thumbnail of alternative image of {{ $product['title'] }}"
                         class="dib w-20 ma3"
                    >
                @endforeach
            </div>
        </div>
        <div class="w-50 pa4">
            <p class="ff-title mb2 mt0">{{ ucwords(strtolower($product['title'])) }}</p>
            <p class="ff-fine-body col-p mt0 mb4">{{ $product['code'] }}</p>
            <p class="ff-fine-body">{!! $product['writeup'] !!}</p>
            @include('front.partials.button-link', ['link' => '/stores', 'block' => true, 'buttonText' => 'Find Location'])
        </div>
    </section>
    <related-products fetch-url="/services/products/{{ $product['slug'] }}/related-products"></related-products>
@endsection