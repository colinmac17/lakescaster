<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('partials.head')

<body>
    <div id="app">
        @include('partials.nav')
        <main class="main container py-4">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
