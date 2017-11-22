@extends('front.base', ['pageName' => 'col-lg-'])

@section('content')
    <header class="banner-heading mesh-bg bb bw2 mb4 h4 flex flex-column items-center justify-center tc">
        <h1 class="strong-type f1 mb0">{{ $article->title }}</h1>
        <p class="col-p strong-type ttu f5 f4-ns">{{ $article->published_on->toFormattedDateString() }}</p>
    </header>
    <img src="{{ $article->titleImage() }}"
         alt="Title image of {{ $article->title }}"
         class="db mw7 mv5 center"
    >
    <section class="mw7 f5 f4-ns center-ns lh-title mh3 article-body">
        {!! $article->body !!}
    </section>
    <section class="tc mv5">
        <p class="tc f5 f4-ns">Share this article</p>
        <a href="#" class="link mh2">
            @include('svgicons.facebook', ['classes' => 'icon icon-d'])
        </a>
        <a href="#" class="link mh2">
            @include('svgicons.twitter', ['classes' => 'icon icon-d'])
        </a>
        <a href="#" class="link mh2">
            @include('svgicons.email', ['classes' => 'icon icon-d'])
        </a>
    </section>
    @include('front.partials.back-button', [
            'link' => '/news',
            'block' => true,
            'classes' => 'mv5 col-d',
            'buttonText' => 'Back To Articles'
        ])
@endsection