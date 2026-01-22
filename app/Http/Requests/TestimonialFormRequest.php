<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class TestimonialFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'feedback' => 'required|string|max:5000',
            'avatar_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'rating' => 'nullable|integer|min:1|max:5',
            'project_id' => 'nullable|exists:projects,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // For updates, make image fields nullable without requiring them
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['avatar_image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
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
            'name.required' => 'The testimonial name is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'feedback.required' => 'The feedback text is required.',
            'feedback.max' => 'The feedback must not exceed 5000 characters.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating must not exceed 5.',
            'project_id.exists' => 'The selected project does not exist.',
            'avatar_image.image' => 'The avatar image must be a valid image file.',
            'avatar_image.max' => 'The avatar image must not exceed 2MB.',
        ];
    }
}
