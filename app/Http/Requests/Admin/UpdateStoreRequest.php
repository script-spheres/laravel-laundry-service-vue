<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'address_lat' => 'nullable',
            'address_long' => 'nullable',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email',
            'manager_phone_number' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'store_code' => 'nullable|string',
            'active_status' => 'required|in:active,inactive',
        ];
    }
}
