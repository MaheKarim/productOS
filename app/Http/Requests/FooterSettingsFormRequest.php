<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class FooterSettingsFormRequest extends FormRequest
{
    /**
     * Determine if user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'is_active' => 'sometimes|boolean',
            'order' => 'sometimes|integer|min:0',
            'logo_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'logo_image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'linkedin_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
            'email' => 'nullable|email|max:255',
            'column1_links' => 'nullable|array',
            'column1_links.*.text' => 'nullable|string|max:255',
            'column1_links.*.url' => 'nullable|url|max:500',
            'column2_links' => 'nullable|array',
            'column2_links.*.text' => 'nullable|string|max:255',
            'column2_links.*.url' => 'nullable|url|max:500',
            'column3_links' => 'nullable|array',
            'column3_links.*.text' => 'nullable|string|max:255',
            'column3_links.*.url' => 'nullable|url|max:500',
            'copyright_text' => 'nullable|string|max:500',
            'privacy_policy_url' => 'nullable|url|max:500',
            'terms_url' => 'nullable|url|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ];

        // For updates, make image fields nullable without requiring them
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['logo_image'] = 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp';
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
            'logo_text.max' => 'The logo text must not exceed 255 characters.',
            'description.max' => 'The description must not exceed 500 characters.',
            'linkedin_url.url' => 'The LinkedIn URL must be a valid URL.',
            'twitter_url.url' => 'The Twitter URL must be a valid URL.',
            'github_url.url' => 'The GitHub URL must be a valid URL.',
            'email.email' => 'The email must be a valid email address.',
            'column1_links.*.url' => 'All links in column 1 must be valid URLs.',
            'column2_links.*.url' => 'All links in column 2 must be valid URLs.',
            'column3_links.*.url' => 'All links in column 3 must be valid URLs.',
            'logo_image.image' => 'The logo image must be a valid image file.',
            'logo_image.max' => 'The logo image must not exceed 2MB.',
        ];
    }
}
