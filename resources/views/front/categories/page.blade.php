@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('content')
    <header class="banner-heading mesh-bg mb5 bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">Our Product Categories</h1>
    </header>
    <section class="flex flex-wrap justify-around contained center mv5">
        @foreach($categories as $category)
            <div class="ma3 mw-20 pa3 col-w-bg">
                <a href="/categories/{{ $category->slug }}" class="link col-d">
                    <img src="{{ $category->imageUrl('thumb') }}"
                         alt="Image for {{ $category->title }} category">
                    <p class="f3 f4-ns b">{{ $category->title }}</p>
                </a>
            </div>
        @endforeach
    </section>
@endsection