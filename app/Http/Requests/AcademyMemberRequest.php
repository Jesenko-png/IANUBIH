<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademyMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageNews() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'academic_title' => ['nullable', 'string', 'max:120'],
            'category_bs' => ['nullable', 'string', 'max:160'],
            'category_en' => ['nullable', 'string', 'max:160'],
            'position_bs' => ['nullable', 'string', 'max:160'],
            'position_en' => ['nullable', 'string', 'max:160'],
            'field_bs' => ['required', 'string', 'max:180'],
            'field_en' => ['required', 'string', 'max:180'],
            'institution_bs' => ['nullable', 'string', 'max:180'],
            'institution_en' => ['nullable', 'string', 'max:180'],
            'country_bs' => ['nullable', 'string', 'max:100'],
            'country_en' => ['nullable', 'string', 'max:100'],
            'bio_bs' => ['nullable', 'string', 'max:5000'],
            'bio_en' => ['nullable', 'string', 'max:5000'],
            'email' => ['nullable', 'email', 'max:190'],
            'website_url' => ['nullable', 'url:http,https', 'max:500'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120', 'dimensions:min_width=240,min_height=240'],
            'remove_photo' => ['sometimes', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    public function attributes(): array
    {
        return __('members.admin.validation');
    }
}
