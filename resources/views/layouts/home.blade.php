<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @include('partials.head')
<body>
    @include('partials.nav')
<main role="main">
    @yield('content')
</main>
    @include('partials.footer')
</body>
</html>