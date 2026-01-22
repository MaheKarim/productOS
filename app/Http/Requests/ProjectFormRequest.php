<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class ProjectFormRequest extends FormRequest
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
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'thumbnail' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'category' => 'nullable|string|max:100',
            'external_link' => 'nullable|url|max:500',
            'metric_value' => 'nullable|string|max:255',
            'metric_label' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'users' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:100',
            'related_tools' => 'nullable|array',
            'related_tools.*' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // For updates, make image fields nullable without requiring them
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
            $rules['thumbnail'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
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
            'title.required' => 'The project title is required.',
            'title.max' => 'The title must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 5000 characters.',
            'category.max' => 'The category must not exceed 100 characters.',
            'external_link.url' => 'The external link must be a valid URL.',
            'image.image' => 'The image must be a valid image file.',
            'image.max' => 'The image must not exceed 2MB.',
            'thumbnail.image' => 'The thumbnail must be a valid image file.',
            'thumbnail.max' => 'The thumbnail must not exceed 2MB.',
        ];
    }
}
