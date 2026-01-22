<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class AboutSectionFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer|min:0',
            'heading' => 'required|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'philosophy1_title' => 'nullable|string|max:255',
            'philosophy1_description' => 'nullable|string|max:1000',
            'philosophy2_title' => 'nullable|string|max:255',
            'philosophy2_description' => 'nullable|string|max:1000',
            'philosophy3_title' => 'nullable|string|max:255',
            'philosophy3_description' => 'nullable|string|max:1000',
            'philosophy4_title' => 'nullable|string|max:255',
            'philosophy4_description' => 'nullable|string|max:1000',
            'work_item1' => 'nullable|string|max:255',
            'work_item2' => 'nullable|string|max:255',
            'work_item3' => 'nullable|string|max:255',
            'work_item4' => 'nullable|string|max:255',
            'core_value1' => 'nullable|string|max:255',
            'core_value2' => 'nullable|string|max:255',
            'core_value3' => 'nullable|string|max:255',
            'core_value4' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // For updates, make image fields nullable without requiring them
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'heading.required' => 'The about heading is required.',
            'heading.max' => 'The heading must not exceed 500 characters.',
            'description.max' => 'The description must not exceed 5000 characters.',
            'image.image' => 'The image must be a valid image file.',
            'image.max' => 'The image must not exceed 2MB.',
        ];
    }
}
