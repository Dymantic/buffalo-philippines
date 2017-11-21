<a href="{{ $link ?? '#' }}"
   class="f3 strong-type mt4 link {{ $block ? 'flex' : 'flex-inline' }} items-center justify-center ttu pv2 {{ $classes ?? 'col-d' }}">
    <span>{{ $buttonText }}</span> @include('svgicons.button-arrow', ['classes' => "pb1 ml3 ih3" . ($iconClasses ?? '')])
</a>