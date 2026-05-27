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
            'price' => 'required|integer|min:0',
            'billing_cycle' => 'required|string|in:yearly,monthly,weekly,',
            'next_billing_date' => 'required|date',
            'status' => 'nullable|string|in:active,inactive,cancelled',
            'color_code' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    public function validationData(): array
    {
        return [
            'service_name' => $this->input('serviceName'),
            'price' => $this->input('price'),
            'billing_cycle' => $this->input('billingCycle'),
            'next_billing_date' => $this->input('nextBillingDate'),
            'status' => $this->input('status'),
            'color_code' => $this->input('colorCode'),
            'notes' => $this->input('notes')
        ];
    }
}
