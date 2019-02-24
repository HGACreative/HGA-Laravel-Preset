@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group{{ $errors->has('email') ? ' input--has-error' : '' }}">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" />
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
        <div class="input-group">
            <input type="checkbox" name="remember" id="remember"{{ old('remember') ? ' checked' : '' }} />
            <label for="remember">Remember Me</label>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn--primary">
                Login
            </button>
            <a href="{{ route('password.request') }}">Forgot your password?</a><br />
            <a href="{{ route('register') }}">Need to register an account?</a>
        </div>
    </form>
@stop
