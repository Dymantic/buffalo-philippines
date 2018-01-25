@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb4 flex items-center justify-center tc">
        <h1 class="ff-headline">Search Results</h1>
    </header>
    <section class="mw8 center-ns mh3">
        <p class="f4 f3-ns tc strong-type mv5">We found <span class="col-p">{{ $products->count() }}</span> products matching <span class="col-p">"{{ $search_term }}"</span>.</p>
        <div class="flex flex-wrap justify-around">
            @foreach($products as $product)
                <div class="w-100 w-20-ns mh2 mb3 col-w-bg pa3">
                    <a class="link" href="/products/{{ $product->slug }}">
                        <img src="{{ $product->imageUrl('thumb') }}"
                             alt="Image of {{ $product->title }}">
                    </a>
                    <a class="link" href="/products/{{ $product->slug }}">
                        <p class="ff-title mb0 col-d hv-col-p">{{ $product->title }}</p>
                        <p class="col-p ff-fine-body col-mg hv-col-d mb0 mt2">{{ $product->code }}</p>
                    </a>

                </div>

            @endforeach
        </div>
    </section>
@endsection