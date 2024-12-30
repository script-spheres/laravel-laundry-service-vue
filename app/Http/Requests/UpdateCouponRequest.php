<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255',],
            'description' => ['nullable', 'string',],
            'code' => [
                'required',
                'string',
                Rule::unique('coupons', 'code')->ignore($this->route('coupon')),
            ],
            'discount_type' => ['required', 'in:flat,percentage',],
            'discount_amount' => ['required_if:discount_type,flat',],
            'discount_percentage' => ['required_if:discount_type,percentage',],
            'min_amount' => ['nullable', 'numeric', 'min:0',],
            'max_amount' => ['nullable', 'numeric', 'min:0',],
            'status' => ['required', 'in:active,inactive',],
        ];
    }
}
