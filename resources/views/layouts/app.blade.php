{{--Main APP--}}
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('partials.head')
<body>
    @include('partials.nav')

    <main class="main">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>