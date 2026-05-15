<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'slots' => ['required', 'integer', 'min:1', 'max:100'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'The end date must be after the start date.',
            'start_date.after_or_equal' => 'The start date cannot be in the past.',
        ];
    }
}
