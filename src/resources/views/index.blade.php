@extends('layouts.app')

@section('content')
    @guest
        Hey there. <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a>.
    @else
        You're logged in.
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
@stop
