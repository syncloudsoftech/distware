<div class="card border-0 shadow" x-data="{ filtering: $persist(false).as('license-list-filtering') }">
    <div class="card-body border-bottom">
        <div class="d-flex align-items-center float-end">
            <div class="spinner-border spinner-border-sm float-end" license="status" wire:loading>
                <span class="visually-hidden">{{ __('Loading') }}&hellip;</span>
            </div>
            @can('create', App\Models\License::class)
                <a class="btn btn-secondary ms-3" href="{{ route('licenses.create') }}">
                    <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline ms-1">{{ __('New') }}</span>
                </a>
            @endcan
        </div>
        <h5 class="card-title">{{ __('Licenses') }}</h5>
        <p class="card-text" :class="{ 'mb-0': ! filtering }">
            {{ __('List and manage licenses here.') }}
            <a href="" @click.prevent="filtering = ! filtering">
                <span x-show="filtering">{{ __('Hide filters?') }}</span>
                <span x-show="! filtering">{{ __('Show filters?') }}</span>
            </a>
        </p>
        <div class="row" x-show="filtering" x-transition>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="mb-3">
                    <label class="form-label" for="filter-search">{{ __('Search') }}</label>
                    <input class="form-control" id="filter-search" placeholder="{{ __('Enter name or code') }}&hellip;" wire:model.debounce.500ms="q" value="{{ $q }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3">
                    <label class="form-label" for="filter-plan">{{ __('Plan') }}</label>
                    <select class="form-select" data-widget="dropdown" id="filter-plan">
                        <option value="">{{ __('Any') }}</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->getKey() }}">{{ $plan->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3">
                    <label class="form-label" for="filter-status">{{ __('Status') }}</label>
                    <select class="form-select" data-widget="dropdown" id="filter-status">
                        <option value="">{{ __('Any') }}</option>
                        @foreach(config('fixtures.license_statuses') as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3 mb-md-0">
                    <label class="form-label" for="filter-from-date">{{ __('Created from') }}</label>
                    <input class="form-control" data-widget="datepicker" id="filter-from-date" value="{{ $fromDate }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <div class="mb-3 mb-sm-0">
                    <label class="form-label" for="filter-to-date">{{ __('Created up to') }}</label>
                    <input class="form-control" data-widget="datepicker" id="filter-to-date" value="{{ $toDate }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3" wire:ignore>
                <label class="form-label" for="filter-length">{{ __('Length') }}</label>
                <select class="form-select" data-widget="dropdown" id="filter-length">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
            <tr>
                <th class="bg-light">#</th>
                <th class="bg-light">
                    @if (($order['name'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'desc')">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['name'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('name', false)">{{ __('Name') }}</a>
                        <i class="fas fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('name', 'asc')">{{ __('Name') }}</a>
                    @endif
                </th>
                <th class="bg-light">{{ __('Email address') }}</th>
                <th class="bg-light">{{ __('Status') }}</th>
                <th class="bg-light">
                    @if (($order['created_at'] ?? null) === 'asc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'desc')">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down-alt ms-1"></i>
                    @elseif (($order['created_at'] ?? null) === 'desc')
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', false)">{{ __('Created at') }}</a>
                        <i class="fas fa-sort-amount-down ms-1"></i>
                    @else
                        <a class="text-body" href="" wire:click.prevent="sort('created_at', 'asc')">{{ __('Created at') }}</a>
                    @endif
                </th>
                <th class="bg-light"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($licenses as $license)
                <tr>
                    <td>{{ $license->getKey() }}</td>
                    <td>
                        @can('view', $license)
                            <a href="{{ route('licenses.show', $license) }}">{{ $license->name }}</a>
                        @else
                            {{ $license->name }}
                        @endcan
                    </td>
                    <td><a href="mailto:{{ $license->email }}">{{ $license->email }}</a></td>
                    <td>
                        @switch($license->status)
                            @case('active')
                                <i class="fa-solid fa-check fa-fw text-success me-1"></i>
                                @break
                            @case('revoked')
                                <i class="fa-solid fa-ban fa-fw text-danger me-1"></i>
                                @break
                            @default
                                <i class="fa-regular fa-circle fa-fw text-info me-1"></i>
                                @break
                        @endswitch
                        {{ config('fixtures.license_statuses.'.$license->status) }}
                    </td>
                    <td>{{ Timezone::convertToLocal($license->created_at) }}</td>
                    <td>
                        @can('view', $license)
                            <a class="btn btn-link text-decoration-none btn-sm" href="{{ route('licenses.show', $license) }}">
                                <i class="fa-solid fa-eye me-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $license)
                            <a class="btn btn-info btn-sm" href="{{ route('licenses.edit', $license) }}">
                                <i class="fa-solid fa-pen me-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $license)
                            <button class="btn btn-danger btn-sm" data-bs-title="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $license->getKey() }}">
                                <i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}
                            </button>
                            @include('partials.delete-confirmation', [
                                'id' => 'delete-confirmation-'.$license->getKey(),
                                'action' => route('licenses.destroy', $license),
                                'message' => __('Do you really want to delete this license?'),
                            ])
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="6">
                        {{ __('Could not find any licenses to show.') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($licenses->hasPages())
        <div class="card-body">
            {{ $licenses->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top-0">
        {{ __('Showing :from to :to of :total licenses.', ['from' => $licenses->firstItem() ?: 0, 'to' => $licenses->lastItem() ?: 0, 'total' => $licenses->total()]) }}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#filter-plan').on('select2:select', function (e) {
                @this.plan = e.params.data.id;
            });

            $('#filter-status').on('select2:select', function (e) {
                @this.status = e.params.data.id;
            });

            $('#filter-length').on('select2:select', function (e) {
                @this.length = e.params.data.id;
            });

            $('#filter-from-date').on('change', function (e) {
                @this.fromDate = e.target.value;
            });

            $('#filter-to-date').on('change', function (e) {
                @this.toDate = e.target.value;
            });
        });
    </script>
@endpush
