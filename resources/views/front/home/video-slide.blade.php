<div class="relative flex justify-center items-center banner-size hero-slide {{ $slide->text_colour }}">
    <video src="/videos/{{ $slide->video_path }}"
         class="w-100 z-0" muted autoplay loop playsinline preload
    ></video>
    <p class="absolute banner-text ttu strong-type ma0 f1">{{ $slide->slide_text }}</p>
    <a class="absolute banner-action link strong-type f3 ttu flex items-center"
       href="{{ $slide->action_link }}">{{ $slide->action_text }}
        @include('svgicons.button-arrow', ['classes' => 'ml3 ih3'])
    </a>
</div>