<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top navbar-laravel">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ Auth::guest() ? url('/') : url('/dashboard') }}">
                <i class="ion-icon ion-radio-waves" style="font-size: 20px; margin-right:5px;"></i>{{ config('app.name', 'Lakescaster') }}
            </a>
                <ul class="navbar-nav mr-auto ml-2" id="allSpotsLink">
                    <li class="nav-item">
                        <a class="nav-link" href="/spots">Reports</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto mr-4" id="searchBarMobile">
                    <form id="searchFormMobile" class="form-inline">
                        <div id="searchBoxMobile" data-spots="{{$aSimpleSpots}}"></div>
                    </form>
                </ul>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(isset($aaSpots))
                        <li class="nav-item dropdown" id="toggleSpotDropdown">
                            <a id="spotDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Reports
                            </a>
                            <div id="main-dropdown-menu" class="dropdown-menu" aria-labelledby="spotDropdown">

                                @foreach($aLakes as $sLake)
                                    <div class="dropdown-submenu">
                                        <a id="dropdown-{{$sLake}}" class="dropdown-item dropdown-toggle" href="#">Lake {{$sLake}}</a>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-{{$sLake}}">
                                            @foreach($aaSpots as $aSpot)
                                                @if($aSpot['lake'] === strtolower($sLake))
                                                <a class="dropdown-item"        href="/spots/{{$aSpot['lake']}}/{{$aSpot['short']}}/{{$aSpot['id']}}">{{$aSpot['name']}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/developers" role="button">Developers</a>
                        </li>
                        {{--<li class="nav-item">--}}
                            {{--<a class="nav-link"><span class="badge badge-info top-banner-message">Always Free and Open Source</span></a>--}}
                        {{--</li>--}}
                    </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <form id="searchForm" class="form-inline mr-5" method="" action="">
                        @csrf
                        <div id="searchBox" data-spots="{{$aSimpleSpots}}"></div>
                        {{--<input id="searchBox" data-spots="{{$aSimpleSpots}}" class="form-control mr-sm-2" name="search" type="text" placeholder="Search" aria-label="Search" required>--}}
                        {{--<button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>--}}
                    </form>
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item dropdown" id="toggleUserDropdown">
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