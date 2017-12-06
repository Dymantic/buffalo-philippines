<a href="{{ $link ?? '#' }}"
   class="ff-sub-headline mt4 link {{ $block ? 'flex' : 'flex-inline' }} items-center justify-center pv2 {{ $classes ?? 'col-p' }}">
    @include('svgicons.back_button', ['classes' => "pb1 mr3 ih4" . ($iconClasses ?? '')])
    <span>{{ $buttonText }}</span>
</a>