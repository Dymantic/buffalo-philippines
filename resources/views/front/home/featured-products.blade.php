<section class="col-lg-bg pv6">
    <h3 class="tc ttu strong-type col-d ma0 f1 mb5">Featured Products</h3>
    <div class="flex justify-around mw8 center">
        @foreach(range(1,4) as $item)
            @include('front.home.featured-product')
        @endforeach
    </div>
    <div class="flex justify-around mw8 center">
        @foreach(range(1,4) as $item)
            @include('front.home.featured-product')
        @endforeach
    </div>
    <a href="#" class="col-d f3 center db strong-type mt4 link tc flex items-center justify-center ttu">View Products @include('svgicons.button-arrow', ['classes' => 'ml3 ih3 icon-d'])</a>
</section>