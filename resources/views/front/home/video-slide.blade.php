<div class="relative flex justify-center items-center banner-size hero-slide {{ $slide->text_colour }}">
    <video src="/videos/{{ $slide->video_path }}"
         class="z-0" muted playsinline preload
    ></video>
    <p class="absolute banner-text ttu strong-type ma0 f1">{{ $slide->slide_text }}</p>
    @if($slide->action_link)
    <a class="absolute banner-action link strong-type f3 ttu flex items-center"
       href="{{ $slide->action_link }}">{{ $slide->action_text }}
        @include('svgicons.button-arrow', ['classes' => 'ml3 ih3'])
    </a>
    @endif
</div>