@extends('layouts.backend')

@section('meta')
    <title>{{ $license->name }} | {{ __('Licenses') }} | {{ config('app.name') }}</title>
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
            <li class="breadcrumb-item active" aria-current="page">{{ $license->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.delete-confirmation', [
        'id' => 'delete-confirmation-'.$license->getKey(),
        'action' => route('licenses.destroy', $license),
        'message' => __('Do you really want to delete this license?'),
    ])
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Details') }}</h5>
                    <p class="card-text">{{ __('See information about existing license here.') }}</p>
                    @if (Gate::allows('update', $license) || Gate::allows('delete', $license))
                        <div class="btn-toolbar">
                            @can('update', $license)
                                <a class="btn btn-info me-1" href="{{ route('licenses.edit', $license) }}">
                                    <i class="fa-solid fa-feather"></i> <span class="d-none d-sm-inline ms-1">{{ __('Edit') }}</span>
                                </a>
                            @endcan
                            @can('delete', $license)
                                <button class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $license->getKey() }}">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-sm-inline ms-1">{{ __('Delete') }}</span>
                                </button>
                            @endcan
                        </div>
                    @endif
                </div>
                <div class="table-responsive border-top">
                    <table class="table mb-0">
                        <tbody>
                        <tr>
                            <th class="bg-light">{{ __('Name') }}</th>
                            <td class="w-100">{{ $license->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Email address') }}</th>
                            <td class="w-100"><a href="mailto:{{ $license->email }}">{{ $license->email }}</a></td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Phone number') }}</th>
                            <td class="w-100">
                                @if ($license->phone)
                                    <a href="tel:{{ $license->phone }}">{{ $license->phone }}</a>
                                @else
                                    <span class="text-muted">{{ __('None') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Code') }}</th>
                            <td class="w-100 font-monospace">{{ $license->code }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Plan') }}</th>
                            <td class="w-100">
                                <a href="{{ route('plans.show', $license->plan) }}">{{ $license->plan->name }}</a>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Expires at') }}</th>
                            <td class="w-100">
                                {{ Timezone::convertToLocal($license->expires_at) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Status') }}</th>
                            <td class="w-100">
                                @switch($license->status)
                                    @case('active')
                                        <i class="fa-solid fa-check text-success me-1"></i>
                                    @break
                                    @case('revoked')
                                        <i class="fa-solid fa-ban text-danger me-1"></i>
                                    @break
                                    @default
                                        <i class="fa-regular fa-circle text-info me-1"></i>
                                    @break
                                @endswitch
                                {{ config('fixtures.license_statuses.'.$license->status) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light align-text-top">{{ __('Notes') }}</th>
                            <td class="w-100 text-wrap">
                                @if ($license->notes)
                                    {{ $license->notes }}
                                @else
                                    <span class="text-muted">{{ __('Empty') }}</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-top-0">
                    <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($license->created_at) }}
                    <span class="d-none d-md-inline">
                        &bull; <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($license->updated_at) }}
                    </span>
                </div>
            </div>
            <div class="mb-3 mb-lg-0">
                <livewire:activity-log-list :model="$license" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                @include('partials.activations', compact('license'))
            </div>
            <div class="mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Share') }}</h5>
                        <p class="card-text">
                            {{ __('Send license information on email.') }}
                        </p>
                    </div>
                    <div class="card-body border-top">
                        <form action="{{ route('licenses.send', $license) }}" class="mb-0" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="license-send-email" class="form-label">
                                    {{ __('Email address') }} <span class="text-danger">&ast;</span>
                                </label>
                                <input class="form-control @error('email') is-invalid @enderror" id="license-send-email" name="email" type="email" value="{{ old('email', $license->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i> <span>{{ __('Send') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @include('partials.auditors', ['model' => $license])
        </div>
    </div>
@endsection
