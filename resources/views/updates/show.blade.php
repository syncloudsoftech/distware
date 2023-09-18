@extends('layouts.backend')

@section('meta')
    <title>{{ $update->version }} | {{ __('Updates') }} | {{ config('app.name') }}</title>
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
            <li class="breadcrumb-item active" aria-current="page">{{ $update->version }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    @include('partials.delete-confirmation', [
        'id' => 'delete-confirmation-'.$update->getKey(),
        'action' => route('updates.destroy', $update),
        'message' => __('Do you really want to delete this update?'),
    ])
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Details') }}</h5>
                    <p class="card-text">{{ __('See information about existing update here.') }}</p>
                    @if (Gate::allows('update', $update) || Gate::allows('delete', $update))
                        <div class="btn-toolbar">
                            @can('update', $update)
                                <a class="btn btn-info me-1" href="{{ route('updates.edit', $update) }}">
                                    <i class="fa-solid fa-feather"></i> <span class="d-none d-sm-inline ms-1">{{ __('Edit') }}</span>
                                </a>
                            @endcan
                            @can('delete', $update)
                                <button class="btn btn-danger me-1" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $update->getKey() }}">
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
                            <th class="bg-light">{{ __('Version') }}</th>
                            <td class="w-100">{{ $update->version }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light align-text-top">{{ __('Changelog') }}</th>
                            <td class="w-100 text-wrap">
                                @if ($update->changelog)
                                    {!! $update->changelog !!}
                                @else
                                    <span class="text-muted">{{ __('Empty') }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">{{ __('Published?') }}</th>
                            <td class="w-100">
                                @if ($update->published)
                                    <span class="text-success">
                                        <i class="fa-solid fa-check me-1"></i> {{ __('Yes') }}
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fa-solid fa-times me-1"></i> {{ __('No') }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer border-top-0">
                    <span class="text-muted">{{ __('Created at') }}</span> {{ Timezone::convertToLocal($update->created_at) }}
                    <span class="d-none d-md-inline">
                        &bull; <span class="text-muted">{{ __('Updated at') }}</span> {{ Timezone::convertToLocal($update->updated_at) }}
                    </span>
                </div>
            </div>
            <div class="mb-3 mb-lg-0">
                <livewire:activity-log-list :model="$update" />
            </div>
        </div>
        <div class="col-lg-4">
            <div class="mb-3">
                @include('partials.installers', compact('update'))
            </div>
            @include('partials.auditors', ['model' => $update])
        </div>
    </div>
@endsection
