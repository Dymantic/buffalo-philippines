@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('content')
    <header class="banner-heading mesh-bg col-w-bg bb bw2 mb4 h4 mb5 flex items-center justify-center tc">
        <h1 class="strong-type f1">Buffalo News</h1>
    </header>
    <section class="mw8 center-ns mh3">
        @if($articles->count() === 0)
            <p class="measure-wide center-ns f4 f3-ns tc col-mg">There is currently no news to report. Be sure to check back in from time to time to stay up to date with all of our latest products and news.</p>
        @endif
        @foreach($articles as $article)
            <div class="col-w-bg shadow-4 mv3 flex justify-between">
                <div class="w-30 flex justify-center items-center">
                    <a href="/news/{{ $article->slug }}" class="link nospace">
                        <img src="{{ $article->titleImage('thumb') }}"
                             alt="Thumbnail of article's title image.">
                    </a>
                </div>
                <div class="pa2">
                    <p class="f3 f2-ns b mv0"><a class="link col-d" href="/news/{{ $article->slug }}">{{ $article->title }}</a></p>
                    <p class="ttu col-p strong-type">{{ $article->published_on->toFormattedDateString() }}</p>
                    <p class="measure-wide lh-title f5 f4-ns">{{ $article->intro }}</p>
                </div>
            </div>
        @endforeach
    </section>
@endsection