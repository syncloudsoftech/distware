<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ __('Machines') }}</h5>
        <p class="card-text">{{ __('Below are few of the recent activations.') }}</p>
    </div>
    @php
        $machines = App\Models\Machine::query()->latest()->paginate(5);
    @endphp
    <div class="table-responsive border-top">
        <table class="table mb-0">
            <tbody>
            @forelse($machines as $machine)
                <tr>
                    <th scope="row">
                        <a href="{{ route('licenses.show', $machine->license) }}">
                            {{ last(explode('-', $machine->fingerprint)) }}
                        </a>
                    </th>
                    <td>{{ $machine->platform }}</td>
                    <td>{{ $machine->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <td class="text-center text-muted" colspan="3">
                    {{ __('No activations found.') }}
                </td>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-end border-top-0">
        {{ __('Showing :count of :total activations.', ['count' => count($machines), 'total' => $machines->total()]) }}
    </div>
</div>
