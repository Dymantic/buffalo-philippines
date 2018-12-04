@extends('front.base', ['pageName' => ''])

@section('title')
    Buffalo Tools - Become a Distributor
@endsection

@section('head')
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Buffalo Tools - Become a Distributor',
        'ogImage' => url('/images/facebook_og.jpg'),
        'ogDescription' => 'Would you like to become a Buffalo distributor? Success is guaranteed.'
    ])
@endsection

@section('content')
    <header class="banner-heading mesh-bg bb bw2 flex items-center justify-center tc">
        <h1 class="ff-headline">Become a Distributor</h1>
    </header>
    <section class="pv4-ns">
        <div class="banner-flag ribbon">
            <p class="ribbon-content col-w ff-sub-headline tc">Would you like to become a Buffalo distributor? Success is guaranteed!</p>
        </div>
        <div class="measure-ultra center tc ph4">
            <p class="mv4 ff-body">Why not benefit from Buffalo’s success in your store? Now, Buffalo gives you high-quality products which consumers genuinely want and are specifically looking for. With repeat business guaranteed every year!</p>
            <p class="mv4 ff-body">We’re always looking for potential and reliable distributor partners that want to express Buffalo brand vision and grow their business as much as we want to grow ours in new regions.</p>
            <p class="mv4 ff-body">Contact us to increase your market share and guarantee the growth of your company!</p>
        </div>
        @include('front.partials.button-link', [
            'link' => '#',
            'block' => true,
            'buttonText' => 'Get started',
            'classes' => 'col-d mv4'
        ])
    </section>
    <section>
        <p class="ff-headline-small tc">A Global Network</p>
        <distributor-map></distributor-map>
        <p class="mv4 ff-body tc">Some of our renowned distributors.</p>
        <div class="mv8 tc">
            <div>
                <img src="/images/distributor_logos/robinsons.png"
                     alt="Handyman hardware stores logo" class="h3 dib center">
                <img src="/images/distributor_logos/mitre-ten.jpg"
                     alt="Handyman hardware stores logo" class="h3 dib center">
            </div>
            <div>
                <img src="/images/distributor_logos/hammer_hardware_logo.png"
                     alt="Handyman hardware stores logo" class="h3 dib center">
                <img src="/images/distributor_logos/handyman_logo.jpg"
                     alt="Handyman hardware stores logo" class="h3 dib center">
            </div>
        </div>
        @include('front.partials.button-link', [
            'link' => '#',
            'block' => true,
            'buttonText' => 'Join our network',
            'classes' => 'col-d'
        ])
    </section>
    <section class="ph1 pv4 col-d-bg mt5">
        <p class="ff-headline-small tc col-w">Distributor Benefits</p>
        <div class="flex flex-wrap justify-around mw-large center pv4">
            @include('front.distributors.benefit', [
                'icon' => 'sales_support',
                'title' => 'Sales Support',
                'text' => 'We will provide you with a dedicated team, ready to help you formulate your business tactics and strategy for your country, and to choose the right products for your projects.'
            ])
            @include('front.distributors.benefit', [
                'icon' => 'marketing_collateral',
                'title' => 'Marketing Collateral',
                'text' => 'You will get access to our media library, where you will find all marketing support materials ready for use. Branding and customized marketing and product collateral makes selling our product more effective and efficient.'
            ])
            @include('front.distributors.benefit', [
                'icon' => 'brand_recognition',
                'title' => 'Brand Recognition',
                'text' => 'Buffalo Tools has more than 50 years history and have more than 400 stores around the world. With great brand recognition, we’ll help you boost profits!'
            ])
            @include('front.distributors.benefit', [
                'icon' => 'preferred_pricing',
                'title' => 'Preferred Pricing',
                'text' => 'Working with Buffalo is easy. You get preferred pricing and freight rates depending on order size.'
            ])
            @include('front.distributors.benefit', [
                'icon' => 'education',
                'title' => 'education',
                'text' => 'We’ll help you get more out of your networks by offering free training of our product and customized service-based support to you and your staff.'
            ])
            @include('front.distributors.benefit', [
                'icon' => 'quality_assurance',
                'title' => 'Quality Assurance',
                'text' => 'We provide quality product to our customer and we pay full responsibility for every defective product by one by one replacement. '
            ])
        </div>
    </section>
@endsection