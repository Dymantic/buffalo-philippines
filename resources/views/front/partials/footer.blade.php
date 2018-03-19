<footer class="relative col-d-bg col-w pt5 flex flex-column items-center mesh-d-bg">
    <img src="/images/logos/logo_grey.png"
         alt="Bufalo Tools logo"
         height="90px"
         class="absolute top-0 left-2"
    >
    <div class="flex flex-column flex-row-ns items-center justify-between mw8 center-ns mh3 w-90">
        <div class="w-50 tc">
            {{--connect--}}
            <p class="ttu b">Connect</p>
            <div class="flex items-center justify-center mb4">
                <a href="https://twitter.com/HuangBuffalo" target="_blank" class="mr3 col-w hv-col-p link">
                    @include('svgicons.twitter', ['height' => '20px'])
                </a>
                <a href="https://www.linkedin.com/company/huang-buffalo-co.-ltd" target="_blank" class="mr3 col-w hv-col-p link">
                    @include('svgicons.linkedin', ['height' => '20px'])
                </a>
                <a href="https://www.facebook.com/buffalotoolsph" target="_blank" class="mr3 col-w hv-col-p link">
                    @include('svgicons.facebook', ['height' => '20px'])
                </a>
                <a href="https://www.linkedin.com/company/huang-buffalo-co.-ltd" target="_blank" class="mr3 col-w hv-col-p link">
                    @include('svgicons.instagram', ['height' => '20px'])
                </a>
            </div>
        </div>
        <div class="w-50 flex justify-center">
            {{--quick links--}}
            <div class="tc">
                <p class="ttu b mb0">Quicklinks</p>
                <ul class="list pl0 pt0 mt2">
                    <li class="mb1 mt0"><a class="col-w hv-col-p link" href="#">Locations</a></li>
                    <li class="mb1 mt0"><a class="col-w hv-col-p link" href="#">Products</a></li>
                    <li class="mb1 mt0"><a class="col-w hv-col-p link" href="#">Contact</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-p mv4 hv-col-pd">
        {{--top button--}}
        @include('svgicons.top-button', ['classes' => 'top-button'])
    </div>
    <p class="tc">
        {{--credits and copyright--}}
        &copy; All rights reserved. Beautifully built by <a href="https://dymanticdesign.com"
                                                            target="_blank" class="link col-w hv-dym">Dymantic Design</a>
    </p>
</footer>