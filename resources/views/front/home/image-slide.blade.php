<div class="relative flex justify-center items-center banner-size hero-slide {{ $slide->text_colour }}">
    <picture>
        <source media="(min-width: 60em)" srcset="{{ $slide->imageUrl('banner') }}">
        <source media="(min-width: 30em) and (max-width: 60em)" srcset="{{ $slide->imageUrl('taller') }}">
        <source media="(max-width: 30em)" srcset="{{ $slide->imageUrl('square') }}">
        <img src="{{ $slide->imageUrl('banner') }}"
             alt="A buffalo tools banner slide"
             class="w-100 z-0"
        >
    </picture>
    <p class="absolute banner-text ff-headline ma0">{{ $slide->slide_text }}</p>
    @if($slide->action_link)
    <a class="absolute banner-action link ff-sub-headline flex items-center"
       href="{{ $slide->action_link }}">{{ $slide->action_text }}
        @include('svgicons.button-arrow', ['classes' => 'ml3 ih4'])
    </a>
    @endif
</div>