<div class="flex items-center ma3 col-w-bg pa2">
        <p class="col-d ff-fine-body col-mg mr4">{{ $article->published_on->toFormattedDateString() }}</p>
        <a href="/news/{{ $article->slug }}" class="link ff-title col-d hv-col-p flex-auto">
            {{ $article->title }}
        </a>
        <p class="ma0 mr2">
            <a href="/news/{{ $article->slug }}" class="link col-d hv-col-p">
                @include('svgicons.button-arrow', ['classes' => 'icon-d ih3'])
            </a>
        </p>
</div>