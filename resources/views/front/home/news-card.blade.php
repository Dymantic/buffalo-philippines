<div class="flex ma3 col-w-bg pa2">
    <div class="w-20">
        <a href="/news/{{ $article->slug }}" class="">
            <img src="{{ $article->titleImage('thumb') }}"
                 alt="Title image for {{ $article->title }}" class="mw-100">
        </a>

    </div>
    <div class="ph5 flex-auto">
        <a href="/news/{{ $article->slug }}" class="link ff-title mb1 col-d hv-col-p">
            {{ $article->title }}
        </a>
        <p class="col-d mv1 ff-fine-body col-mg">{{ $article->published_on->toFormattedDateString() }}</p>
        <p class="col-d measure-wide mv1 ff-fine-body">{{ $article->intro }}</p>
        <p class="tr ma0 w-100">
            <a href="/news/{{ $article->slug }}" class="link col-d hv-col-p">
                @include('svgicons.button-arrow', ['classes' => 'icon-d ih3'])
            </a>
        </p>
    </div>
</div>