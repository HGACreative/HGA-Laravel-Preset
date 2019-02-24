@extends('layouts.app')

@section('content')
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}" />

        <div class="input-group{{ $errors->has('email') ? ' input--has-error' : '' }}">
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autofocus autocomplete="off" />
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-group{{ $errors->has('password') ? ' input--has-error' : '' }}">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="off" />
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-group{{ $errors->has('password') ? ' input--has-error' : '' }}">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="off" />
        </div>

        <div class="input-group">
            <button type="submit" class="btn btn-primary">
                Reset Password
            </button>
        </div>
    </form>
@stop
