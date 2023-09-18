@extends('layouts.backend')

@section('meta')
    <title>{{ __('Edit') }} | {{ $license->name }} | {{ __('Licenses') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\License::class)
                <li class="breadcrumb-item"><a href="{{ route('licenses.index') }}">{{ __('Licenses') }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ __('Licenses') }}</li>
            @endcan
            @can('update', $license)
                <li class="breadcrumb-item"><a href="{{ route('licenses.show', $license) }}">{{ $license->name }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $license->name }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Edit') }}</h5>
            <p class="card-text">{{ __('Update existing license details.') }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('licenses.update', $license) }}" method="post">
                        @csrf
                        @method('put')
                        @lockInput($license)
                        @include('licenses.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    @can('view', $license)
                                        <a class="btn btn-outline-dark ms-1" href="{{ route('licenses.show', $license) }}">
                                            {{ __('Cancel') }}
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
