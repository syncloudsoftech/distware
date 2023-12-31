@extends('layouts.auth')

@section('meta')
    <title>{{ __('Create New Account') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Create new account') }}
    </h1>
    <p class="card-text">
        {{ __('Register for a account with us using below form.') }}
        {{ __("It's free, no credit card required.") }}
    </p>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="mb-3">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input autofocus class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" placeholder="{{ __('Name') }}" required value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email address') }}" required type="email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required type="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="{{ __('Confirm password') }}" required type="password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <p class="mb-0">By creating an account with us, you agree having read our <a href="" target="_blank">{{ __('Privacy policy') }}</a> and <a href="" target="_blank">{{ __('Terms of service') }}</a>.</p>
        <div class="d-flex align-items-center my-3">
            <hr class="w-100">
            <span class="text-uppercase px-3">{{ __('Or') }}</span>
            <hr class="w-100">
        </div>
        <p><a href="{{ route('login') }}">Login here</a> if you already have an account.</p>
        <div class="btn-toolbar justify-content-end">
            <button class="btn btn-primary btn-lg">
                {{ __('Register') }} <i class="fa-solid fa-arrow-right ms-1"></i>
            </button>
        </div>
    </form>
@endsection
