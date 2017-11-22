<a href="{{ $link ?? '#' }}"
   class="f3 strong-type mt4 link {{ $block ? 'flex' : 'flex-inline' }} items-center justify-center ttu pv2 {{ $classes ?? 'col-d' }}">
    @include('svgicons.back_button', ['classes' => "pb1 mr3 ih3 icon-d" . ($iconClasses ?? '')])
    <span>{{ $buttonText }}</span>
</a>