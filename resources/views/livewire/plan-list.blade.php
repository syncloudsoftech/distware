<div class="card border-0 shadow" x-data="{ filtering: $persist(false).as('plan-list-filtering') }">
    <div class="card-body border-bottom">
        <div class="d-flex align-items-center float-end">
            <div class="spinner-border spinner-border-sm float-end" plan="status" wire:loading>
                <span class="visually-hidden">{{ __('Loading') }}&hellip;</span>
            </div>
            @can('create', App\Models\Plan::class)
                <a class="btn btn-secondary ms-3" href="{{ route('plans.create') }}">
                    <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline ms-1">{{ __('New') }}</span>
                </a>
            @endcan
        </div>
        <h5 class="card-title">{{ __('Plans') }}</h5>
        <p class="card-text" :class="{ 'mb-0': ! filtering }">
            {{ __('List and manage plans here.') }}
            <a href="" @click.prevent="filtering = ! filtering">
                <span x-show="filtering">{{ __('Hide filters?') }}</span>
                <span x-show="! filtering">{{ __('Show filters?') }}</span>
            </a>
        </p>
        <div class="row" x-show="filtering" x-transition>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="mb-3 mb-sm-0">
                    <label class="form-label" for="filter-search">{{ __('Search') }}</label>
                    <input class="form-control" id="filter-search" placeholder="{{ __('Enter name') }}&hellip;" wire:model.debounce.500ms="q" value="{{ $q }}">
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-xl-3 offset-md-4 offset-xl-6" wire:ignore>
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
                <th class="bg-light">{{ __('Months') }}</th>
                <th class="bg-light">{{ __('Licenses') }}</th>
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
            @forelse ($plans as $plan)
                <tr>
                    <td>{{ $plan->getKey() }}</td>
                    <td>
                        @can('view', $plan)
                            <a href="{{ route('plans.show', $plan) }}">{{ $plan->name }}</a>
                        @else
                            {{ $plan->name }}
                        @endcan
                    </td>
                    <td>{{ __(':count months', ['count' => $plan->entitlements['months'] ?? 0]) }}</td>
                    <td>{{ __(':count licenses', ['count' => $plan->licenses()->count()]) }}</td>
                    <td>{{ Timezone::convertToLocal($plan->created_at) }}</td>
                    <td>
                        @can('view', $plan)
                            <a class="btn btn-link text-decoration-none btn-sm" href="{{ route('plans.show', $plan) }}">
                                <i class="fa-solid fa-eye me-1"></i> {{ __('Details') }}
                            </a>
                        @endcan
                        @can('update', $plan)
                            <a class="btn btn-info btn-sm" href="{{ route('plans.edit', $plan) }}">
                                <i class="fa-solid fa-pen me-1"></i> {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $plan)
                            <button class="btn btn-danger btn-sm" data-bs-title="{{ __('Delete') }}" data-bs-toggle="modal" data-bs-target="#delete-confirmation-{{ $plan->getKey() }}">
                                <i class="fa-solid fa-trash me-1"></i> {{ __('Delete') }}
                            </button>
                            @include('partials.delete-confirmation', [
                                'id' => 'delete-confirmation-'.$plan->getKey(),
                                'action' => route('plans.destroy', $plan),
                                'message' => __('Do you really want to delete this plan?'),
                            ])
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center text-muted" colspan="6">
                        {{ __('Could not find any plans to show.') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($plans->hasPages())
        <div class="card-body">
            {{ $plans->onEachSide(1)->links() }}
        </div>
    @endif
    <div class="card-footer border-top-0">
        {{ __('Showing :from to :to of :total plans.', ['from' => $plans->firstItem() ?: 0, 'to' => $plans->lastItem() ?: 0, 'total' => $plans->total()]) }}
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#filter-length').on('select2:select', function (e) {
                @this.length = e.params.data.id;
            });
        });
    </script>
@endpush
