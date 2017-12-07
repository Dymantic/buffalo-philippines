<a href="{{ $link ?? '#' }}"
   class="ff-sub-headline mt4 link {{ $block ? 'flex' : 'flex-inline' }} items-center justify-center pv2 {{ $classes ?? 'col-p' }} hv-col-pd">
    <span>{{ $buttonText }}</span> @include('svgicons.button-arrow', ['classes' => "pb1 ml3 ih4" . ($iconClasses ?? '')])
</a>