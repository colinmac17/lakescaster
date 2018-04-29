{{--Main APP--}}
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    @if(isset($sName))
      @include('partials.spothead')
    @else
        @include('partials.head')
    @endif
<body>
    @include('partials.nav')

    <main class="main">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>