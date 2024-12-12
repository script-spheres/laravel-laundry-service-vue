<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'image' => 'required_without:new_image|sometimes',
            'new_image' => 'nullable',
            'status' => 'sometimes|required|in:active,inactive',
        ];
    }
}
