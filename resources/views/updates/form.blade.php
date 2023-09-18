@php
    if (empty($update)) {
        $update = new App\Models\Update([
            'published' => true,
        ]);
    }
@endphp

<input type="hidden" name="form" value="update">

<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="update-version">{{ __('Version') }} <span class="text-danger">&ast;</span></label>
    <div class="col-sm-8">
        <input autofocus class="form-control @error('version') is-invalid @enderror" id="update-version" name="version" required value="{{ old('version', $update->version) }}">
        @error('version')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="update-changelog">{{ __('Changelog') }}</label>
    <div class="col-sm-8">
        <textarea class="form-control @error('changelog') is-invalid @enderror" data-widget="wysiwyg" id="update-changelog" name="changelog" rows="3">{{ old('changelog', $update->changelog) }}</textarea>
        @error('changelog')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
@php
    $old_published = old('form') === 'update' ? old('published') : $update->published;
@endphp
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="update-published">{{ __('Published?') }}</label>
    <div class="col-sm-8">
        <div class="form-check form-switch mt-sm-2">
            <input class="form-check-input @error('published') is-invalid @enderror" id="update-published" name="published" type="checkbox" role="switch" value="1" @if ($update->published) checked @endif>
            <label class="form-check-label" for="update-published">{{ __('Yes') }}</label>
        </div>
        @error('published')
            <div class="invalid-feedback d-inline-block">{{ $message }}</div>
        @enderror
    </div>
</div>
