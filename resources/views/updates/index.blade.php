@extends('layouts.backend')

@section('meta')
    <title>{{ __('Updates') }} | {{ config('app.name') }}</title>
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ config('app.name') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Updates') }}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <livewire:update-list />
@endsection
