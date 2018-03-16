@extends('front.base')

@section('content')

    <section class="mt5 mw8 center-ns mh3 flex flex-column flex-row-ns justify-between">
        <div class="db dn-ns">
            <p class="ff-title mb2 mt0">
                {{ ucwords(strtolower($product['title'])) }}
                @if($product['is_new'])
                <span class="mh3 col-p-bg col-w b ph2 py-1 ttu ff-title br2">NEW</span>
                @endif
            </p>
            <p class="ff-fine-body col-p mt0 mb4">{{ $product['code'] }}</p>
        </div>
        <div class="w-100 w-50-ns pa4">
            <image-gallery :images="{{ json_encode(array_merge([$product['main_image']], $product['gallery_images'])) }}" product-title="{{ $product['title'] }}"></image-gallery>
        </div>
        <div class="w-100 w-50-ns pa4">
            <p class="dn db-ns ff-title mb2 mt0">
                {{ ucwords(strtolower($product['title'])) }}
                @if($product['is_new'])
                    <span class="mh3 col-p-bg col-w b ph2 py-1 ttu ff-title br2">NEW</span>
                @endif
            </p>
            <p class="dn db-ns ff-fine-body col-p mt0 mb4">{{ $product['code'] }}</p>
            <div class="ff-fine-body">{!! $product['writeup'] !!}</div>
            <p class="f4 col-d b">{{ $product['price'] }}</p>

            @include('front.partials.button-link', ['link' => '/stores', 'block' => true, 'buttonText' => 'Find Location'])
        </div>
    </section>
    <related-products fetch-url="/services/products/{{ $product['slug'] }}/related-products"></related-products>
@endsection