<section class="ph3 pv4 col-d-bg">
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