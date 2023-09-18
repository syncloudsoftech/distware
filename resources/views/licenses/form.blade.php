@php
    if (empty($license)) {
        $license = new App\Models\License([
            'status' => 'fresh',
        ]);
    }
@endphp

<input type="hidden" name="form" value="license">

<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-name">{{ __('Name') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('name') is-invalid @enderror" id="license-name" name="name" required value="{{ old('name', $license->name) }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-email">{{ __('Email address') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input class="form-control @error('email') is-invalid @enderror" id="license-email" name="email" type="email" required value="{{ old('email', $license->email) }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-phone">{{ __('Phone number') }}</label>
    <div class="col-sm-8">
        <input class="form-control @error('phone') is-invalid @enderror" id="license-phone" name="phone" value="{{ old('phone', $license->phone) }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-code">{{ __('Code') }}</label>
    <div class="col-sm-8">
        <input class="form-control-plaintext font-monospace" id="license-code" readonly value="{{ $license->code ?? '-' }}">
    </div>
</div>
@php
    $old_plan_id = old('plan_id', $license->plan?->getKey());
    $old_plan = $old_plan_id ? App\Models\Plan::query()->find($old_plan_id) : null;
    $plans = App\Models\Plan::query()->orderBy('name')->get();
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-plan-id">{{ __('Plan') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <select class="form-select @error('plan_id') is-invalid @enderror" data-widget="dropdown" id="license-plan-id" name="plan_id" required>
            @foreach($plans as $plan)
                <option value="{{ $plan->getKey() }}" @if ($old_plan && $old_plan->getKey() === $plan->getKey()) selected @endif>{{ $plan->name }}</option>
            @endforeach
        </select>
        @error('plan_id')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $old_expires_at = old('expires_at', $license->expires_at);
    if ($old_expires_at instanceof DateTime) {
        $old_expires_at = Carbon\Carbon::parse($old_expires_at)->timezone(auth()->user()->timezone)->format('Y-m-d H:i:00');
    }
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-expires-at">{{ __('Expires at') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autocomplete="off" class="form-control @error('expires_at') is-invalid @enderror" data-widget="datetimepicker" id="license-expires-at" name="expires_at" required value="{{ $old_expires_at }}">
        @error('expires_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $old_status = old('status', $license->status);
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-status">{{ __('Status') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <select class="form-select @error('status') is-invalid @enderror" data-widget="dropdown" id="license-status" name="status" required>
            @foreach(config('fixtures.license_statuses') as $key => $name)
                <option value="{{ $key }}" @if ($old_status === $key) selected @endif>{{ $name }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="license-notes">{{ __('Notes') }}</label>
    <div class="col-sm-8">
        <textarea class="form-control @error('notes') is-invalid @enderror" id="license-notes" name="notes" rows="3">{{ old('notes', $license->notes) }}</textarea>
        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
