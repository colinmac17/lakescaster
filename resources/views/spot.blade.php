@extends('layouts.app')

@section('content')
    <div clas="container p-5">
        <div id="spot" data-user="{{$aUser}}" data-auth="{{$bUser}}" data-description="{{$sDescription}}" data-date="{{date('m/d/Y')}}" data-name="{{$sName}}" data-path="{{$sPath}}" data-reviews="{{$aReviews}}"></div>
    </div>
@endsection