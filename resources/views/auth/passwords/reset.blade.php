@extends('layouts.authpages')

@section('content')
<div class="login-userset">
    <div class="login-logo logo-normal">
        <img src="{{ asset('assets/img/logo.png') }}" alt="img" style="max-width: 400px;">
    </div>
    <a href="index.html" class="login-logo logo-white">
        <img src="{{ asset('assets/img/logo-white.png') }}" alt="" style="max-width: 400px;">
    </a>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="login-userheading">
            <h3>Reset Password</h3>
        </div>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-login">
            <label>{{ __('Email Address') }}</label>
            <div class="form-addons">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        
        <div class="form-login">
            <label>{{ __('Password') }}</label>
            <div class="form-addons">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-login">
            <label>{{ __('Confirm Password') }}</label>
            <div class="form-addons">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-login">
            <button type="submit" class="btn btn-login">{{ __('Reset Password') }}</button>
        </div>
    </form>
</div>
@endsection