<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class ServiceFormRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'icon' => 'nullable|string|max:50',
            'icon_type' => 'nullable|string|in:fa-solid,fa-regular,fa-brands',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'problem_solves' => 'nullable|string|max:1000',
            'tangible_outcome' => 'nullable|string|max:1000',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:500',
            'cta_text' => 'nullable|string|max:255',
            'cta_url' => 'nullable|url|max:500',
            'cta_style' => 'nullable|string|in:primary,secondary',
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
            'title.required' => 'The service title is required.',
            'title.max' => 'The title must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 5000 characters.',
            'icon_type.in' => 'The icon type must be one of: fa-solid, fa-regular, fa-brands.',
            'cta_url.url' => 'The CTA URL must be a valid URL.',
            'cta_style.in' => 'The CTA style must be either primary or secondary.',
            'image.image' => 'The image must be a valid image file.',
            'image.max' => 'The image must not exceed 2MB.',
        ];
    }
}
