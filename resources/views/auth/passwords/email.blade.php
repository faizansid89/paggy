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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="login-userheading">
                <h3>Reset Password</h3>
            </div>

            <div class="form-login">
                <label>{{ __('Email Address') }}</label>
                <div class="form-addons">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-login">
                @if (Route::has('login'))
                    <div class="alreadyuser">
                        <h4><a href="{{ route('login') }}" class="hover-a">Back to Login</a></h4>
                    </div>
                @endif
            </div>
            
            <div class="form-login">
                <button type="submit" class="btn btn-login">{{ __('Send Password Reset Link') }}</button>
            </div>
        </form>
    </div>
@endsection