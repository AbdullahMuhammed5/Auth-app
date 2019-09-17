@extends('layouts.basic')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <div class="thumbnail">
                <div>{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    <div class="thumbnail-description">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}
                    </div>
                </div>
            </div>
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-primary p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
@endsection
