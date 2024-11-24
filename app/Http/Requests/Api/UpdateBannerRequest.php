<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'image' => 'required_without:new_image|sometimes',
            'new_image' => 'nullable',
            'active_status' => 'sometimes|required|in:active,inactive',
        ];
    }
}
