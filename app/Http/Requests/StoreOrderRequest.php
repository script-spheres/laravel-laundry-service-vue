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
            'customer_id' => ['required', 'exists:customers'],
            'store_id' => ['required', 'exists:stores'],
            'timeslot_id' => ['nullable', 'exists:timeslots'],
            'coupon_id' => ['nullable', 'exists:coupons'],
            'status' => ['required'],
            'total_weight_kg' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'delivery_date' => ['required', 'date'],
            'quick_note' => ['nullable'],
        ];
    }
}
