<nav class="flex justify-between items-center h3 col-d-bg">
    <div class="flex items-start items-center h-100">
        <a href="/admin"
           class="pl2 flex items-center mr4"><img src="/images/logos/navbar_admin.png"
                                                  alt="Logo"
                                                  height="60px"
            >
        </a>
        <dropdown name="Products">
            <div slot="dropdown">
                <a href="/admin/search/products"
                   class="mh3 col-p mv2 tr link">Search</a>
                <a href="/admin/featured-products"
                   class="mh3 col-p mv2 tr link">Featured</a>
                <a href="/admin/categories"
                   class="mh3 col-p mv2 tr link">Categories</a>
            </div>
        </dropdown>
        <a href="/admin/locations"
           class="mh3 col-w link">Locations</a>
        <a href="/admin/slideshow/slides"
           class="mh3 col-w link">Banner</a>
        <a href="/admin/articles"
           class="mh3 col-w link">Insights</a>
    </div>
    <div>
        <form action="/admin/search/products"
              method="GET">
            <input type="text"
                   name="q"
                   id="nav-search"
                   class="col-d-bg col-p bb bt-0 br-0 bl-0 outline-0 h2 w5"
                   placeholder="Search products...">
        </form>
    </div>
    <div class="flex justify-end items-center h-100">
        @if(auth()->user()->superadmin)
            <a href="/admin/users"
               class="mh3 col-w link">Users</a>
        @endif
        <dropdown name="{{ auth()->user()->email }}">
            <div slot="dropdown">
                <reset-password url="/admin/me/password"
                                button-text="Reset"></reset-password>
                {{--<a class="link mv2 ph4 pv2 nowrap col-p hv-bg-grey" href="">Reset Password</a>--}}
                <form action="{{ route('logout') }}"
                      method="POST"
                      class="mv2 ph4 hv-bg-grey pv2">
                    {!! csrf_field() !!}
                    <button class="link col-p bn col-bg-trans pa0 sans"
                            type="submit">Logout
                    </button>
                </form>
            </div>
        </dropdown>
    </div>
</nav>