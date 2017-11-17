@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb4 h5 flex items-center justify-center tc">
        <h1 class="strong-type f1">{{ $categoryMenu['title'] }}</h1>
    </header>
    <section class="flex">
        <div class="w-25">
            <nested-menu class="min-h-100 col-w-bg" :menu-structure='{{ json_encode($categoryMenu) }}'></nested-menu>
        </div>
        <div class="w-75">
            <product-list fetch-url="/services/categories/{{ $slug }}/products"></product-list>
        </div>
    </section>
@endsection