@extends('layouts.authpages')

@section('content')
    <div class="login-userset">
        <div class="login-logo logo-normal">
            <img src="{{ asset('assets/img/logo.png') }}" alt="img" style="max-width: 400px;">
        </div>
        <a href="{{ route('login')}}" class="login-logo logo-white">
            <img src="{{ asset('assets/img/logo-white.png') }}" alt="" style="max-width: 400px;">
        </a>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="login-userheading">
                <h3>{{ __('Register') }}</h3>
                <h4>Please create an account</h4>
            </div>

            <!-- main alert @s -->
            @include('partials.alerts')
            <!-- main alert @e -->

           
            <input id="user_type" type="hidden" class="form-control @error('user_type') is-invalid @enderror" name="user_type" value="3" required>

            <div class="form-login">
                <label>Name of Participant:</label>
                <div class="form-addons">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-login">
                <label>Phone Number:</label>
                <div class="form-addons">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="phone" value="{{ old('name') }}" required autocomplete="name" autofocus onkeypress="return isNumber(event)">
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-login">
                <label>I attest that I am over 18 years of age: </label>
                <div class="form-addons">
                    <select name="age" class="form-control">
                        <option>Select Option</option>
                        <option value="yes">Yes I am over 18</option>
                        <option value="no">No I am under 18</option>
                    </select>
                </div>
            </div>

            <div class="form-login">
                <label>{{ __('Email Address') }}</label>
                <div class="form-addons">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
            </div>

            <div class="form-login">
                <label>{{ __('Password') }}</label>
                <div class="form-addons">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-login">
                <label>{{ __('Confirm Password') }}</label>
                <div class="form-addons">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-login">
                <button type="submit" class="btn btn-login">{{ __('Register') }}</button>
            </div>

            <div class="form-login" style="text-align: right;">
                @if (Route::has('login'))
                    <div class="alreadyuser">
                        <h4><a href="{{ route('login') }}" class="hover-a">Back to Login</a></h4>
                    </div>
                @endif
            </div>
        </form>
    </div>
@endsection
