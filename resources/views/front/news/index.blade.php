@extends('front.base', ['pageName' => 'col-lg-bg'])

@section('title')
    News from BUFFALO® Tools
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => 'News from Buffalo Tools Philippines',
        'ogImage' => url('/images/facebook_og.jpg'),
        'ogDescription' => 'Find out the latest news, views and stories from Buffalo Tools Philippines. From new products to events in our industry, you will find it here.'
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg col-w-bg bb bw2 mb4 mb5 flex items-center justify-center tc">
        <h1 class="ff-headline">Buffalo News</h1>
    </header>
    <section class="mw8 center-ns mh3 mv5">
        @if($articles->count() === 0)
            <p class="measure-wide center-ns ff-large-body tc col-mg">There is currently no news to report. Be sure to check back in from time to time to stay up to date with all of our latest products and news.</p>
        @endif
        @foreach($articles as $article)
            <div class="col-w-bg shadow-4 mb4 flex justify-between">
                <div class="dn w-25 flex-ns justify-center items-center">
                    <a href="/news/{{ $article->slug }}" class="link nospace">
                        <img src="{{ $article->titleImage('thumb') }}"
                             alt="Thumbnail of article's title image.">
                    </a>
                </div>
                <div class="pr2 pb2 pl4 pt3 flex-auto">
                    <p class="ff-title b mv0"><a class="link col-d" href="/news/{{ $article->slug }}">{{ $article->title }}</a></p>
                    <p class="col-p ff-fine-body mv1">{{ $article->published_on->toFormattedDateString() }}</p>
                    <p class="measure-wide lh-title ff-fine-body">{{ $article->intro }}</p>
                </div>
            </div>
        @endforeach
    </section>
@endsection