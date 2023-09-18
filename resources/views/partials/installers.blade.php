<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ __('Installers') }}</h5>
        <p class="card-text">
            {{ __('Below is a list of uploaded installers.') }}
        </p>
    </div>
    @php
        $installers = $update->getMedia('installers');
    @endphp
    @if (count($installers))
        <ul class="list-group list-group-flush border-top">
            @foreach ($installers as $installer)
                <li class="list-group-item p-3">
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
                    <p class="mb-2">
                        {{ $installer->mime_type }} &bullet; {{ bytes_to_str($installer->size) }}
                    </p>
                    <div class="btn-toolbar gap-1">
                        <a class="btn btn-secondary btn-sm" href="{{ URL::signedRoute('updates.download', [$update, $installer], now()->addDay()) }}" target="_blank">
                            <i class="fa-solid fa-download me-1"></i> {{ __('Download') }}
                        </a>
                        @can('update', $update)
                            <form action="{{ route('updates.detach', [$update, $installer]) }}" class="mb-0" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    @can('update', $update)
        <div class="card-body border-top">
            <form action="{{ route('updates.attach', $update) }}" class="mb-0" enctype="multipart/form-data" method="post">
                @csrf
                @php
                    $old_platform = old('platform', 'windows');
                @endphp
                <div class="mb-3">
                    <label for="installer-platform" class="form-label">
                        {{ __('Platform') }} <span class="text-danger">&ast;</span>
                    </label>
                    <select class="form-select @error('platform') is-invalid @enderror" id="installer-platform" data-widget="dropdown" name="platform" required>
                        @foreach (config('fixtures.platforms') as $key => $name)
                            <option value="{{ $key }}" @if ($key === $old_platform) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('platform')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="installer-file" class="form-label">
                        {{ __('Document or image') }} <span class="text-danger">&ast;</span>
                    </label>
                    <input class="form-control @error('file') is-invalid @enderror" id="installer-file" name="file" type="file" required>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary">
                    <i class="fa-solid fa-upload me-1"></i> <span>{{ __('Upload') }}</span>
                </button>
            </form>
        </div>
    @endcan
</div>
