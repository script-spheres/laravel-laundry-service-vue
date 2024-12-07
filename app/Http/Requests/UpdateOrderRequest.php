<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'customer_id' => 'required|exists:App\Models\Customer,id',
            'store_id' => 'required|exists:App\Models\Store,id',
            'order_status' => 'required|in:pending,in-progress,ready-to-deliver,delivered',
            'total_weight_kg' => 'required|numeric|min:0',
            'sub_total' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'delivery_date' => 'nullable|date|after_or_equal:today',
            'quick_note' => 'nullable|string|max:255',
        ];
    }
}
