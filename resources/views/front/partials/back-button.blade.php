<a href="{{ $link ?? '#' }}"
   class="ff-sub-headline mt4 link {{ $block ? 'flex' : 'flex-inline' }} items-center justify-center pv2 {{ $classes ?? 'col-d' }}">
    @include('svgicons.back_button', ['classes' => "pb1 mr3 ih4 icon-d" . ($iconClasses ?? '')])
    <span>{{ $buttonText }}</span>
</a>