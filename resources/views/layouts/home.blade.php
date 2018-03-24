<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('partials.head')
<body>
    @include('partials.nav')
<main role="main">
    @include('partials.flash')
    @yield('content')
</main>
    @include('partials.footer')
</body>
</html>