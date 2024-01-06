@php
    if (empty($plan)) {
        $plan = new App\Models\Plan();
    }
@endphp

<input type="hidden" name="form" value="plan">

<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="plan-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="plan-name" name="name" required value="{{ old('name', $plan->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $old_entitlements = (array) old('entitlements', $plan->entitlements);
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label">{{ __('Entitlements') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <div class="mt-sm-2">
            @foreach (config('fixtures.entitlements') as $key => $name)
                <div class="form-check">
                    <input class="form-check-input @error('entitlements') is-invalid @enderror" id="plan-entitlement-{{ $key }}" name="entitlements[]" type="checkbox" value="{{ $key }}" @if (in_array($key, $old_entitlements)) checked @endif>
                    <label class="form-check-label" for="plan-entitlement-{{ $key }}">{{ $name }}</label>
                </div>
            @endforeach
        </div>
        @error('entitlements')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
