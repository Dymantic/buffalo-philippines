<footer class="relative col-d-bg col-w pt6 flex flex-column items-center mesh-d-bg">
    <img src="/images/logos/navbar.png"
         alt="Bufalo Tools logo"
         height="90px"
         class="absolute top-0 left-1"
    >
    <div class="flex justify-between mw7 center-ns mh3 w-90">
        <div class="w-50 tl">
            {{--connect--}}
            <p class="ttu b">Connect</p>
            <div class="flex items-center justify-start">
                <a href="#" class="mr3 col-w link">
                    @include('svgicons.twitter', ['height' => '20px'])
                </a>
                <a href="#" class="mr3 col-w link">
                    @include('svgicons.linkedin', ['height' => '20px'])
                </a>
                <a href="#" class="mr3 col-w link">
                    @include('svgicons.facebook', ['height' => '20px'])
                </a>
                <a href="#" class="mr3 col-w link">
                    @include('svgicons.instagram', ['height' => '20px'])
                </a>
            </div>
        </div>
        <div class="w-50 flex justify-end">
            {{--quick links--}}
            <div class="tl">
                <p class="ttu b mb0">Quicklinks</p>
                <ul class="list pl0 pt0 mt2">
                    <li class="mb1 mt0"><a class="col-w link" href="#">Locations</a></li>
                    <li class="mb1 mt0"><a class="col-w link" href="#">Products</a></li>
                    <li class="mb1 mt0"><a class="col-w link" href="#">Contact</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="col-p mv5">
        {{--top button--}}
        @include('svgicons.top-button')
    </div>
    <p>
        {{--credits and copyright--}}
        &copy; All rights reserved. Beautifully built by <a href="https://dymanticdesign.com"
                                                            target="_blank" class="link col-w">Dymantic Design</a>
    </p>
</footer>