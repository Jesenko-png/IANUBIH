<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageNews() ?? false;
    }

    public function rules(): array
    {
        $rules = [
            'title_bs' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'kind_bs' => ['required', 'string', 'max:160'],
            'kind_en' => ['required', 'string', 'max:160'],
            'programme_bs' => ['required', 'string', 'max:160'],
            'programme_en' => ['required', 'string', 'max:160'],
            'summary_bs' => ['required', 'string', 'max:2000'],
            'summary_en' => ['required', 'string', 'max:2000'],
            'project_status' => ['required', Rule::in(['active', 'completed'])],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];

        foreach (['bs', 'en'] as $locale) {
            for ($index = 0; $index < 4; $index++) {
                $rules['meta_'.$locale.'.'.$index.'.label'] = ['nullable', 'string', 'max:120'];
                $rules['meta_'.$locale.'.'.$index.'.value'] = ['nullable', 'string', 'max:500'];
            }
        }

        return $rules;
    }

    public function attributes(): array
    {
        return __('projects_cms.validation_attributes');
    }
}
