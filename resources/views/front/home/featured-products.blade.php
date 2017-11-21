<section class="col-lg-bg pv6">
    <h3 class="tc ttu strong-type col-d ma0 f1 mb5">Featured Products</h3>
    <div class="flex flex-wrap justify-around mw8 center">
        @foreach($featured as $featured_product)
            @include('front.home.featured-product')
        @endforeach
    </div>
    @include('front.partials.button-link', [
            'link' => '/categories',
            'block' => true,
            'buttonText' => 'View Products'
        ])
</section>