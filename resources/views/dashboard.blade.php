@extends('layouts.backend')

@section('meta')
    <title>{{ __('Dashboard') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
        </ol>
    </nav>
@endsection

@push('flash')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
@endpush

@section('content')
    <div class="card border-0 shadow mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ __('Dashboard') }}</h5>
            <p class="card-text">
                {{ __('Hey :name, you are now logged in!', ['name' => strtolower(Auth::user()->name)]) }}
                {{ Illuminate\Foundation\Inspiring::quotes()->random() }}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-4 col-xl-3">
            <a class="btn btn-secondary w-100 p-3 mb-3" href="{{ route('licenses.index') }}">
                <div class="d-flex justify-content-between">
                    <i class="fa-solid fa-unlock-keyhole fa-fw fa-2x"></i>
                    <span class="h5 mb-0 align-self-center">{{ __(':count Licenses', ['count' => App\Models\License::query()->count()]) }}</span>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <a class="btn btn-secondary w-100 p-3 mb-3" href="{{ route('licenses.index') }}">
                <div class="d-flex justify-content-between">
                    <i class="fa-solid fa-fingerprint fa-fw fa-2x"></i>
                    <span class="h5 mb-0 align-self-center">{{ __(':count Machines', ['count' => App\Models\Machine::query()->count()]) }}</span>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <a class="btn btn-secondary w-100 p-3 mb-3" href="{{ route('updates.index') }}">
                <div class="d-flex justify-content-between">
                    <i class="fa-solid fa-file-zipper fa-fw fa-2x"></i>
                    <span class="h5 mb-0 align-self-center">{{ __(':count Updates', ['count' => App\Models\Update::query()->count()]) }}</span>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <a class="btn btn-secondary w-100 p-3 mb-3" href="{{ route('plans.index') }}">
                <div class="d-flex justify-content-between">
                    <i class="fa-solid fa-boxes-stacked fa-fw fa-2x"></i>
                    <span class="h5 mb-0 align-self-center">{{ __(':count Plans', ['count' => App\Models\Plan::query()->count()]) }}</span>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="mb-3 mb-lg-0">
                @include('partials.dashboard.recent-activations')
            </div>
        </div>
        <div class="col-lg-6">
            @include('partials.dashboard.recent-licenses')
        </div>
    </div>
@endsection
