<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ __('Machines') }}</h5>
        <p class="card-text">{{ __('Below are recent machines this license was used on.') }}</p>
    </div>
    @php
        $machines = $license->machines()->latest()->take(5)->get();
    @endphp
    @if ($machines->count())
        <ul class="list-group list-group-flush border-top">
            @foreach($machines as $machine)
                <li class="list-group-item p-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <h5 class="font-monospace mb-0">
                            <abbr title="{{ $machine->fingerprint }}">{{ last(explode('-', $machine->fingerprint)) }}</abbr>
                        </h5>
                        <small>{{ Timezone::convertToLocal($machine->created_at) }}</small>
                    </div>
                    <p class="mb-1">{{ $machine->platform }} &bullet; <a href="https://ipapi.co/{{ $machine->ip }}" target="_blank">{{ $machine->ip }}</a></p>
                    <p class="mb-0">{{ __('Last seen at') }} {{ Timezone::convertToLocal($machine->last_active_at) }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <div class="card-body border-top">
            <p class="card-text text-center text-muted">{{ __('No activations yet.') }}</p>
        </div>
    @endif
</div>
