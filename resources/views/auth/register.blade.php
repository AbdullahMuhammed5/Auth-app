@extends('layouts.basic')

@section('content')
    <h3>Register to IN+</h3>
    <p>Create account to see it in action.</p>
    <form class="m-t" role="form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                   placeholder="First Name" value="{{ old('first_name') }}" required="" autocomplete="first_name" autofocus>
            @error('first_name')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                   placeholder="Last Name" value="{{ old('last_name') }}" required="" autocomplete="last_name" autofocus>
            @error('last_name')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email" value="{{ old('email') }}" required="" autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                   placeholder="Phone Number" value="{{ old('phone') }}" required="" autocomplete="phone" autofocus>
            @error('phone')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Password" value="{{ old('password') }}" required="" autocomplete="password" autofocus>
            @error('password')
            <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Confirm Password" required="" autocomplete="new-password" autofocus>
        </div>
        <div class="form-group">
            <div class="checkbox i-checks"><label> <input type="checkbox"><i></i> Agree the terms and policy </label></div>
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Register') }}</button>
        <p class="text-muted text-center"><small>Already have an account?</small></p>
        <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">Login</a>
    </form>

@endsection
