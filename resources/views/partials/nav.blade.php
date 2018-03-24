<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top navbar-laravel">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="ion-icon ion-radio-waves" style="font-size: 20px; margin-right:5px;"></i>{{ config('app.name', 'Lakescaster') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(isset($aaSpots))
                        <li class="nav-item dropdown">
                            <a id="spotDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Reports
                            </a>
                            <div class="dropdown-menu" aria-labelledby="spotDropdown">

                                @foreach($aaSpots as $aSpot)
                                    <a class="dropdown-item" href="/spots/{{$aSpot['lake']}}/{{$aSpot['short']}}/{{$aSpot['id']}}">{{$aSpot['name']}}</a>
                                @endforeach


                            </div>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/developers" role="button">Developers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"><span class="badge badge-info top-banner-message">Always Free and Open Source</span></a>
                        </li>
                    </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/dashboard">Dashboard</a>
                                <a class="dropdown-item" href="/user/settings">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>