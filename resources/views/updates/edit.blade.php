@extends('layouts.backend')

@section('meta')
    <title>{{ __('Edit') }} | {{ $update->version }} | {{ __('Updates') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\Update::class)
                <li class="breadcrumb-item"><a href="{{ route('updates.index') }}">{{ __('Updates') }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ __('Updates') }}</li>
            @endcan
            @can('update', $update)
                <li class="breadcrumb-item"><a href="{{ route('updates.show', $update) }}">{{ $update->version }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $update->version }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit')  }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body">
            <h5 class="card-title">{{ __('Edit') }}</h5>
            <p class="card-text">{{ __('Update existing update details.') }}</p>
        </div>
        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <form action="{{ route('updates.update', $update) }}" method="post">
                        @csrf
                        @method('put')
                        @lockInput($update)
                        @include('updates.form')
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <div class="btn-toolbar">
                                    <button class="btn btn-success">
                                        <i class="fas fa-check me-1"></i> {{ __('Save') }}
                                    </button>
                                    @can('view', $update)
                                        <a class="btn btn-outline-dark ms-1" href="{{ route('updates.show', $update) }}">
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
