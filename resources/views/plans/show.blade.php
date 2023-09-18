@extends('layouts.backend')

@section('meta')
    <title>{{ $plan->name }} | {{ __('Plans') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            @can('viewAny', App\Models\Plan::class)
                <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">{{ __('Plans') }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ __('Plans') }}</li>
            @endcan
            <li class="breadcrumb-item active" aria-current="page">{{ $plan->name }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.delete-confirmation', [
        'id' => 'delete-confirmation-'.$plan->getKey(),
        'action' => route('plans.destroy', $plan),
        'message' => __('Do you really want to delete this plan?'),
    ])
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Details') }}</h5>
                    <p class="card-text">{{ __('See information about existing plan here.') }}</p>
                    @if (Gate::allows('update', $plan) || Gate::allows('delete', $plan))
                        <div class="btn-toolbar">
                            @can('update', $plan)
                                <a class="btn btn-info me-1" href="{{ route('plans.edit', $plan) }}">
                                    <i class="fa-solid fa-feather"></i> <span class="d-none d-sm-inline ms-1">{{ __('Edit') }}</span>
                                </a>
                            @endcan
                            @can('delete', $plan)
                                <button class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $plan->getKey() }}">
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
                            <td class="w-100">{{ $plan->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Months') }}</th>
                            <td class="w-100">
                                {{ __(':count months', ['count' => $plan->entitlements['months'] ?? 0]) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Licenses') }}</th>
                            <td class="w-100">
                                @php
                                    $count = $plan->licenses()->count();
                                @endphp
                                {{ __(':count licenses', compact('count')) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-top-0">
                    <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($plan->created_at) }}
                    <span class="d-none d-md-inline">
                        &bull; <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($plan->updated_at) }}
                    </span>
                </div>
            </div>
            <div class="mb-3 mb-lg-0">
                <livewire:activity-log-list :model="$plan" />
            </div>
        </div>
        <div class="col-lg-4">
            @include('partials.auditors', ['model' => $plan])
        </div>
    </div>
@endsection
