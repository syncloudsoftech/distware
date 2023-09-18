@extends('layouts.auth')

@section('meta')
    <title>{{ __('Set New Password') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <h1 class="h4 card-title mb-3">
        {{ __('Set new password') }}
    </h1>
    <p class="card-text">
        {{ __('Choose a strong, new password below to regain access to your account.') }}
    </p>
    <form action="{{ route('password.update') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ request('token') }}">
        <div class="mb-3">
            <!--suppress HtmlFormInputWithoutLabel -->
            <input autofocus class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email address') }}" required type="email" value="{{ old('email', request('email')) }}">
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
        <div class="btn-toolbar justify-content-end">
            <button class="btn btn-primary btn-lg">
                <i class="fa-solid fa-check me-1"></i> {{ __('Update') }}
            </button>
        </div>
    </form>
@endsection
