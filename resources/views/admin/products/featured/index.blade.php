@extends('admin.base')

@section('content')
    <div class="flex justify-between items-center">
        <h1 class="f1 normal">Featured Products</h1>
        <div class="flex justify-end items-center">

        </div>
    </div>
    <section>
        <p>There are currently {{ $featured_products->count() }} featured products. Up to eight will be shown on the home page.</p>
        <div class="flex flex-wrap mw8 center-ns">
            @foreach($featured_products as $featured_product)
                <div class="flex flex-column justify-between items-start col-w-bg mh2 mv4 br3 w-20">
                    <div class="pv4 flex justify-center items-center flex-auto ph2">
                        <a href="/admin/products/{{ $featured_product->id }}">
                            <img src="{{ $featured_product->imageUrl('thumb') }}"
                                 alt=""
                                 class="mw-100"
                            >
                        </a>
                    </div>
                    <div class="pl2">
                        <p class="b body-type col-d ttu mb2">{{ $featured_product->title }}</p>
                        <p class="ttu col-mg f6 body-type mt0">{{ $featured_product->code }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
@endsection