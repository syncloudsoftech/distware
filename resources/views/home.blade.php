@extends('layouts.site')

@section('meta')
    <title>{{ __('Home') }} | {{ config('app.name') }}</title>
@endsection

@section('content')
    <div class="container my-auto py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                @include('flash::message')
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Download') }}</h5>
                        <p class="card-text">
                            {{ __('To download latest update, enter and submit your license code below.') }}
                        </p>
                        <form action="{{ route('download') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="download-code">
                                    {{ __('License code') }} <span class="text-danger">&ast;</span>
                                </label>
                                <input class="form-control form-control-lg font-monospace text-center @error('code') is-invalid @enderror" id="download-code" name="code" required value="{{ old('code', $code ?? '') }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-download me-1"></i> {{ __('Download') }}
                            </button>
                        </form>
                    </div>
                    @if (($installers ?? null) && $installers->isNotEmpty())
                        <div class="card-body bg-light border-top">
                            {{ __('Latest version is :version, released on :created_at i.e., :difference.', ['version' => $update->version, 'created_at' => Timezone::convertToLocal($update->created_at), 'difference' => $update->created_at->diffForHumans()]) }}
                        </div>
                        <div class="list-group list-group-flush border-top">
                            @foreach ($installers as $installer)
                                <a class="list-group-item list-group-item-action p-3" href="{{ URL::signedRoute('updates.download', [$update, $installer]) }}" target="_blank">
                                    <div class="d-flex w-100 justify-content-between mb-1">
                                        <h5 class="text-primary mb-1">
                                            @if (in_array($installer->getCustomProperty('platform'), ['osx', 'osx-m1']))
                                                <i class="fa-brands fa-apple me-1"></i>
                                            @else
                                                <i class="fa-brands fa-{{ $installer->getCustomProperty('platform') }} me-1"></i>
                                            @endif
                                            {{ config('fixtures.platforms.'.$installer->getCustomProperty('platform')) }}
                                        </h5>
                                        <small>{{ Timezone::convertToLocal($installer->created_at) }}</small>
                                    </div>
                                    <p class="mb-0">
                                        {{ $installer->mime_type }} &bullet; {{ bytes_to_str($installer->size) }}
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @elseif ($code ?? null)
                        <div class="card-body border-top">
                            <p class="card-text text-center text-muted">
                                {{ __('No published updates found.') }}
                            </p>
                        </div>
                    @endif
                </div>
                <p class="mb-0">
                    @auth
                        <a class="text-body" href="{{ route('logout') }}" onclick="event.preventDefault(); logout()">{{ __('Logout') }}</a>
                        &bull;
                    @endauth
                    <strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}
                </p>
            </div>
        </div>
    </div>
@endsection
