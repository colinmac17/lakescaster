@extends('layouts.app')

@section('content')
    <div clas="container p-5">
        <div id="spot" data-description="{{$sDescription}}" data-date="{{date('m/d/Y')}}" data-name="{{$sName}}" data-path="{{$sPath}}"></div>
    </div>
@endsection