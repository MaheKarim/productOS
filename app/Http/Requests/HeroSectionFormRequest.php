<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class HeroSectionFormRequest extends FormRequest
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
            'badge_text' => 'nullable|string|max:255',
            'title' => 'required|string|max:500',
            'subtitle' => 'nullable|string|max:1000',
            'cta_primary_text' => 'nullable|string|max:255',
            'cta_primary_url' => 'nullable|string|max:500',
            'cta_secondary_text' => 'nullable|string|max:255',
            'cta_secondary_url' => 'nullable|string|max:500',
            'background_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'profile_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'stat1_icon' => 'nullable|string|max:50',
            'stat1_value' => 'nullable|string|max:255',
            'stat1_label' => 'nullable|string|max:255',
            'stat2_icon' => 'nullable|string|max:50',
            'stat2_value' => 'nullable|string|max:255',
            'stat2_label' => 'nullable|string|max:255',
            'stat3_icon' => 'nullable|string|max:50',
            'stat3_value' => 'nullable|string|max:255',
            'stat3_label' => 'nullable|string|max:255',
            'floating_card1_icon' => 'nullable|string|max:50',
            'floating_card1_title' => 'nullable|string|max:255',
            'floating_card1_subtitle' => 'nullable|string|max:255',
            'floating_card2_icon' => 'nullable|string|max:50',
            'floating_card2_title' => 'nullable|string|max:255',
            'floating_card2_subtitle' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // For updates, make image fields nullable without requiring them
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['background_image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
            $rules['profile_image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
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
            'title.required' => 'The hero title is required.',
            'title.max' => 'The hero title must not exceed 500 characters.',
            'subtitle.max' => 'The subtitle must not exceed 1000 characters.',
            'cta_primary_url.string' => 'The primary CTA URL must be text.',
            'cta_secondary_url.string' => 'The secondary CTA URL must be text.',
            'background_image.image' => 'The background image must be a valid image file.',
            'background_image.max' => 'The background image must not exceed 2MB.',
            'profile_image.image' => 'The profile image must be a valid image file.',
            'profile_image.max' => 'The profile image must not exceed 2MB.',
        ];
    }
}
