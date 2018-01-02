<div class="relative flex justify-center items-center banner-size hero-slide {{ $slide->text_colour }}">
    <video src="/videos/{{ $slide->video_path }}"
         class="z-0" muted playsinline preload
    ></video>
    @include('front.home.slide-overlay')
</div>