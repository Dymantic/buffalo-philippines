@extends('front.base')

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb4 h5 flex items-center justify-center tc">
        <h1 class="strong-type f1">{{ $product['title'] }}</h1>
    </header>
    <section class="flex justify-between">
        <div class="w-50">
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
        <div class="w-50">
            <p class="f3 f2-ns mb2">{{ ucwords(strtolower($product['title'])) }}</p>
            <p class="col-p mt0 mb4">{{ $product['code'] }}</p>
            <p>{!! $product['writeup'] !!}</p>
            @include('front.partials.button-link', ['link' => '/stores', 'block' => true, 'buttonText' => 'Find Location'])
        </div>
    </section>
@endsection