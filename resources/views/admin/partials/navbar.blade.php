<nav class="flex justify-between items-center h3 col-p-bg">
    <div class="flex items-start items-center h-100">
        <a href="/admin" class="pl2 flex items-center"><img src="/images/logos/navbar.png"
                              alt="Logo"
                              height="60px"
            >
        </a>
        <a href="/admin/articles" class="mh3 col-w link">Insights</a>
        <a href="/admin/slideshow/slides" class="mh3 col-w link">Banner</a>
        <a href="/admin/locations" class="mh3 col-w link">Locations</a>
        <dropdown name="Products">
            <div slot="dropdown">
                <a href="#"
                   class="mh3 col-p mv2 tr link">Search</a>
                <a href="/admin/categories"
                   class="mh3 col-p mv2 tr link">Categories</a>
            </div>
        </dropdown>
    </div>
    <div class="flex justify-end items-center h-100">
        @if(auth()->user()->superadmin)
        <a href="/admin/users" class="mh3 col-w link">Users</a>
        @endif
        <dropdown name="{{ auth()->user()->email }}">
            <div slot="dropdown">
                <reset-password url="/admin/me/password" button-text="Reset"></reset-password>
                {{--<a class="link mv2 ph4 pv2 nowrap col-p hv-bg-grey" href="">Reset Password</a>--}}
                <form action="{{ route('logout') }}" method="POST" class="mv2 ph4 hv-bg-grey pv2">
                    {!! csrf_field() !!}
                    <button class="link col-p bn col-bg-trans pa0 sans" type="submit">Logout</button>
                </form>
            </div>
        </dropdown>
    </div>
</nav>