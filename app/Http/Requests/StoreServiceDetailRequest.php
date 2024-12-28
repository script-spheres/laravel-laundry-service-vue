<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceDetailRequest extends FormRequest
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
            'service_id' => ['required', 'exists:\App\Models\Service,id'],
            'category_id' => ['required', 'exists:\App\Models\Category,id'],
            'service_item_id' => ['required', 'exists:\App\Models\ServiceItem,id'],
            'unit_id' => ['required', 'exists:units,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'numeric', 'min:1'],
        ];
    }
}
