@extends('layouts.app')

@section('content')
    <h1>Reset Password</h1>

    @if (session('status'))
        <div class="alert alert--success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group{{ $errors->has('email') ? ' input--has-error' : '' }}">
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" />
            @if ($errors->has('email'))
                <span class="help-block" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="input-group">
            <button type="submit" class="btn btn--primary">
                Send Password Reset Link
            </button>
        </div>
    </form>
@endsection
