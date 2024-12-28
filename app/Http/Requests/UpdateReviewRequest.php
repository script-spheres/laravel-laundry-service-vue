<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'order_id' => ['required', 'exists:\App\Models\Order,id'],
            'customer_id' => ['required', 'exists:\App\Models\Customer,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'review' => ['required', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'in_testimonial' => ['nullable', 'boolean'],
        ];
    }
}
