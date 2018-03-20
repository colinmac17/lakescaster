@extends('layouts.app')

@section('content')
    <div clas="container p-5">
        <h1 class="text-center">{{$sName}}</h1>
        <div id="spot" data-date="{{date('m/d/Y')}}" data-path="{{$sPath}}" data-img="{{$sImg}}"></div>
    </div>
@endsection