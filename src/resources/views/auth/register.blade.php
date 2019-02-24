@extends('layouts.app')

@section('content')
    <h1>Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group{{ $errors->has('first_name') ? ' input--has-error' : '' }}">
            <label for="first_name">First name</label>
            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="off" />
            @if ($errors->has('first_name'))
                <span class="help-block" role="alert">
                    {{ $errors->first('first_name') }}
                </span>
            @endif
        </div>
        <div class="input-group{{ $errors->has('last_name') ? ' input--has-error' : '' }}">
            <label for="last_name">Last name</label>
            <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" />
            @if ($errors->has('last_name'))
                <span class="help-block" role="alert">
                    {{ $errors->first('last_name') }}
                </span>
            @endif
        </div>
        <div class="input-group{{ $errors->has('email') ? ' input--has-error' : '' }}">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="{{ old('email') }}" required autocomplete="off" />
            @if ($errors->has('email'))
                <span class="help-block" role="alert">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>
        <div class="input-group{{ $errors->has('password') ? ' input--has-error' : '' }}">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="off" />
            @if ($errors->has('password'))
                <span class="help-block" role="alert">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>
        <div class="input-group{{ $errors->has('password') ? ' input--has-error' : '' }}">
            <label for="password_confirmation">Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="off" />
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn--primary">
                Register
            </button>
            <a href="{{ route('login') }}">Already have an account?</a>
        </div>
    </form>
@stop
