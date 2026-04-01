<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePromiseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'promiser_name' => 'required|string|max:255',
            'promise_content' => 'required|string',
            'date_made' => 'required|date',
            'deadline' => 'nullable|date|after_or_equal:date_made',
            'status' => 'nullable|string|in:pending,kept,broken',
            'importance_level' => 'nullable|integer|min:1|max:5',

        ];
    }

    public function messages(): array {
        return [


        ];
    }
}
