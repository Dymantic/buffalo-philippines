@extends('front.base', ['pageName' => 'tool-bg'])

@section('content')
    <div class="col-w-bg mw8 pv5 center-ns">
        <header class="banner-heading mt0 flex flex-column items-center justify-center tc">
            <h1 class="ff-headline-small mb0">{{ $article->title }}</h1>
            <p class="col-p ff-body">{{ $article->published_on->format('d F Y') }}</p>
        </header>
        <img src="{{ $article->titleImage() }}"
             alt="Title image of {{ $article->title }}"
             class="db mw7 mv5 center"
        >
        <section class="mw7 ff-body center-ns lh-copy mh3 article-body">
            {!! $article->body !!}
        </section>
        <section class="tc mv5">
            <p class="tc ff-title col-mg">Share this article</p>
            <a href="#"
               class="link col-d hv-col-p mh2">
                @include('svgicons.facebook', ['classes' => 'icon ih5 hv-col-p'])
            </a>
            <a href="#"
               class="link col-d hv-col-p mh2">
                @include('svgicons.twitter', ['classes' => 'icon ih5'])
            </a>
            <a href="#"
               class="link col-d hv-col-p mh2">
                @include('svgicons.email', ['classes' => 'icon ih5'])
            </a>
        </section>
        @include('front.partials.back-button', [
            'link' => '/news',
            'block' => true,
            'classes' => 'mv5 col-p',
            'buttonText' => 'Back To Articles'
        ])
    </div>
@endsection

