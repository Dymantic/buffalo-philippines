<div class="main-navbar fixed flex justify-end relative items-center bw2 col-p col-d-bg w-100 top-0 z-999 strong-type">
    <a href="/"
       class="absolute nav-logo link">
        <img src="/images/logos/navbar.png"
             alt="Buffalo Tools logo"
             class="fixed z-999"
             height="95px">
    </a>
    <input type="checkbox"
           id="nav-trigger"
           class="dn">
    <nav class="nav-list flex justify-end pr2 items-center strong-type col-d-bg">
        <a class="ph4-ns f3 link ttu col-w hov-s @activeclass('about')"
           href="/about">About</a>
        {{--<a class="ph4-ns f3 link ttu col-w hov-s @activeclass('blog')" href="/blog">Blog</a>--}}
        <a class="ph4-ns f3 link ttu col-w hov-s @activeclass('categories')"
           href="/categories">Products</a>
        <a class="ph4-ns f3 link ttu col-w hov-s @activeclass('news')"
           href="/news">News</a>
        <a class="ph4-ns f3 link ttu col-w hov-s @activeclass('contact')"
           href="/contact">Contact</a>
        <label class="dn-ns ph4-ns f3 link ttu col-w"
               for="nav-trigger">Close</label>
    </nav>
    <label for="nav-trigger"
           class="strong-type db dn-l link ttu col-w pr3"
           id="nav-trigger">Menu</label>
</div>