<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:App\Models\Customer,id'],
            'store_id' => ['nullable', 'exists:App\Models\Store,id'],
            'total_weight_kg' => ['nullable', 'numeric'],
            'sub_total' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
            'tax_amount' => ['nullable', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'paid_amount' => ['nullable', 'numeric'],
            'delivery_date' => ['nullable', 'date', 'after_or_equal:today'],
            'quick_note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
