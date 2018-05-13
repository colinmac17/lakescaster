@extends('layouts.user')

@section('content')
    <div class="container">
        <p>Hey <b>{{session()->get('name')}}</b> it looks like your account was deleted on {{date('m-d-Y', time(session()->get('updated_at')))}}.</p>
        <p>If you would like to recover your account, please click the button below.</p>
        <p>Please email the developer of this app <b>Colin McAtee</b> at colin@colinmcatee.com if you have any additional questions.</p>
        <br/>
        <p>Thank you!</p>
        <form action="/account/recover/{{session()->get('id')}}" method="POST">
            @csrf
            <input type="hidden" value="{{session()->get('id')}}"/>
            <button type="submit" class="btn btn-success">Recover Account</button>
        </form>
        <a role="button" class="btn btn-link" href="https://lakescaster.com">Back to Lakescaster</a>
    </div>

@endsection