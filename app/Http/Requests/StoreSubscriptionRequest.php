<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'service_name' => 'required|string|max:255',
            'price' => 'required|integer',
            'billing_cycle' => 'required|string',
            'next_billing_date' => 'required|date',
            'status' => 'nullable|string',
            'color_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
