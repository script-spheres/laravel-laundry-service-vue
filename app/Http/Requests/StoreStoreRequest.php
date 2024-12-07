<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'address_lat' => 'nullable|numeric',
            'address_long' => 'nullable|numeric',
            'email' => 'required|email|unique:App\Models\Store,email,',
            'phone_number' => 'required|string|unique:App\Models\Store,phone_number,',
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email|unique:App\Models\Store,manager_email,',
            'manager_phone_number' => 'nullable|string|unique:App\Models\Store,manager_phone_number,',
            'additional_info' => 'nullable|string',
            'store_code' => 'nullable|string|unique:App\Models\Store,store_code,',
            'status' => 'required|in:active,inactive',
        ];
    }
}
