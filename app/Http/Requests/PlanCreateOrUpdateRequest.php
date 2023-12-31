<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanCreateOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'entitlements' => ['required', 'array', 'min:1'],
            'entitlements.*' => ['required', 'string', Rule::in(array_keys(config('fixtures.entitlements')))],
            'published' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string', 'max:65535'],
        ];
    }
}
