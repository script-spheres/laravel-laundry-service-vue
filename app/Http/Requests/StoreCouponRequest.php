<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'title' => ['required'],
            'description' => ['required'],
            'code' => ['required'],
            'discount_type' => ['required'],
            'discount_amount' => ['nullable', 'numeric'],
            'discount_percentage' => ['nullable', 'numeric'],
            'min_amount' => ['required', 'numeric'],
            'max_amount' => ['required', 'numeric'],
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date'],
            'usage_limit' => ['nullable', 'integer'],
            'used_count' => ['required', 'integer'],
            'active_status' => 'required|in:active,inactive',
        ];
    }
}
