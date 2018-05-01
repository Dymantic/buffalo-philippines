@extends('front.base', ['pageName' => ''])

@section('title')
    {{ $category->title }} - Buffalo Tools Philippines
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => $category->title . 'Buffalo Tools Philippines',
        'ogImage' => url($category->imageUrl()),
        'ogDescription' => $category->description
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb4 flex items-center justify-center tc">
        <h1 class="ff-headline">{{ $category->title }}</h1>
    </header>
    <show-category :menu-structure='{{ json_encode($categoryMenu) }}'
                   products-fetch-url="/services/categories/{{ $slug }}/products"
    ></show-category>
@endsection