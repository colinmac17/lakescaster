@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Welcome back, {{ $name }}</div>

                <div class="card-body">

                    You are logged in!
                    <div id="mobileLogout">
                        <p>
                            <a class="btn btn-link text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"
                            >Logout</a>
                        </p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
