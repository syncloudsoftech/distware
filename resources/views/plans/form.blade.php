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
    $old_entitlements_months = old('entitlements.months', $plan->entitlements['months'] ?? '');
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="plan-entitlements-months">{{ __('Months') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input class="form-control @error('entitlements.months') is-invalid @enderror" id="plan-entitlements-months" name="entitlements[months]" required type="number" value="{{ $old_entitlements_months }}">
        @error('entitlements.months')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
