@extends('layouts.backend')

@section('meta')
    <title>{{ __('Licenses') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Licenses') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <livewire:license-list />
@endsection
