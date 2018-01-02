<p class="absolute banner-text ff-headline ma0 dn db-ns">{{ $slide->slide_text }}</p>
@if($slide->action_link)
    @include('front.partials.button-link', [
        'link' => $slide->action_link,
        'block' => true,
        'buttonText' => $slide->action_text,
        'classes' => 'absolute banner-action'
    ])
    {{--<a class="absolute banner-action link ff-sub-headline flex items-center"--}}
    {{--href="{{ $slide->action_link }}">{{ $slide->action_text }}--}}
    {{--@include('svgicons.button-arrow', ['classes' => 'ml3 ih4'])--}}
    {{--</a>--}}
@endif