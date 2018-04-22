@extends('layouts.app')

@section('content')
    <div clas="container p-5">
        <h1 class="text-center mb-3">All Surf Reports</h1>
        <div class="container" id="spotsByLake">
            <hr/>
            <div class="row">
                @foreach($aLakes as $sLake)
                    <div class="col-sm-12 col-md-offset-2 col-md-4 p-3">
                        <div class="card bg-primary all-spot-card">
                            <div class="card-header text-white">
                                Lake {{$sLake}}
                            </div>
                            <ul class="list-group list-group-flush">
                                @foreach($aaSpots as $aSpot)
                                    @if($aSpot['lake'] === strtolower($sLake))
                                        <li class="list-group-item"><a href="/spots/{{$aSpot['lake']}}/{{$aSpot['short']}}/{{$aSpot['id']}}">{{$aSpot['name']}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection