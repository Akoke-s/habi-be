<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'image' => ['required', 'string'],
            'description' => ['required', 'string'],
            'category_type_id' => ['required', 'integer', 'exists:category_types,id'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'colors' => ['required', 'array'],
            'sizes' => ['required', 'array'],
            'material' => ['required', 'string'],
        ];
    }
}
