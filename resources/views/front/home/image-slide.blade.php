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
    <p class="absolute banner-text ttu strong-type ma0 f1">{{ $slide->slide_text }}</p>
    <a class="absolute banner-action link strong-type f3 ttu flex items-center"
       href="{{ $slide->action_link }}">{{ $slide->action_text }}
        @include('svgicons.button-arrow', ['classes' => 'ml3 ih3'])
    </a>
</div>