@extends('layouts.authpages')

@section('content')
    <div class="login-userset">
        <div class="login-logo logo-normal">
            <img src="{{ asset('assets/img/logo.png') }}" alt="img" style="max-width: 400px;">
        </div>
        <a href="{{ route('login')}}" class="login-logo logo-white">
            <img src="{{ asset('assets/img/logo-white.png') }}" alt="" style="max-width: 400px;">
        </a>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login-userheading">
                <h3>Sign In</h3>
                <h4>Please login to your account</h4>
            </div>

            <div class="form-login">
                <label>Email</label>
                <div class="form-addons">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <img src="{{ asset('assets/img/icons/mail.svg') }}" alt="img">
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-login">
                <label>Password</label>
                <div class="pass-group">
                    <input name="password" id="password" type="password" class="pass-input @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" required autocomplete="current-password">
                    <span class="fas toggle-password fa-eye-slash"></span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="form-login">
                @if (Route::has('password.request'))
                    <div class="alreadyuser">
                        <h4><a href="{{ route('password.request') }}" class="hover-a">Forgot Password?</a></h4>
                    </div>
                @endif
            </div>
            <div class="form-login">
                <button type="submit" class="btn btn-login">Login</button>
            </div>
        </form>
    </div>
@endsection
