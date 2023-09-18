<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ __('Licenses') }}</h5>
        <p class="card-text">{{ __('Below are few of the recently generated licenses.') }}</p>
    </div>
    @php
        $licenses = App\Models\License::query()->latest()->paginate(5);
    @endphp
    <div class="table-responsive border-top">
        <table class="table mb-0">
            <tbody>
            @forelse($licenses as $license)
                <tr>
                    <th scope="row">
                        <a href="{{ route('licenses.show', $license) }}">
                            {{ explode('-', $license->code)[0] }}
                        </a>
                    </th>
                    <td>
                        <a href="{{ route('plans.show', $license->plan) }}">
                            {{ $license->plan->name }}
                        </a>
                    </td>
                    <td>{{ $license->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <td class="text-center text-muted" colspan="3">
                    {{ __('No licenses found.') }}
                </td>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-end border-top-0">
        {{ __('Showing :count of :total licenses.', ['count' => count($licenses), 'total' => $licenses->total()]) }}
    </div>
</div>
