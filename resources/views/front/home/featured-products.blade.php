<section class="col-lg-bg pv6">
    <h3 class="tc ff-headline col-d ma0 mb5">Featured Products</h3>
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