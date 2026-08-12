<?php

namespace App\Http\Requests;

use App\Models\NewsPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageNews() ?? false;
    }

    public function rules(): array
    {
        /** @var NewsPost|null $newsPost */
        $newsPost = $this->route('newsPost');

        return [
            'title_bs' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'category_bs' => ['required', 'string', 'max:100'],
            'category_en' => ['required', 'string', 'max:100'],
            'excerpt_bs' => ['required', 'string', 'max:600'],
            'excerpt_en' => ['required', 'string', 'max:600'],
            'body_bs' => ['required', 'string'],
            'body_en' => ['required', 'string'],
            'image' => [
                Rule::requiredIf($newsPost === null || blank($newsPost->image_path)),
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
                'dimensions:min_width=600,min_height=350',
            ],
            'image_alt_bs' => ['nullable', 'string', 'max:255'],
            'image_alt_en' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title_bs' => 'naslov na bosanskom',
            'title_en' => 'naslov na engleskom',
            'category_bs' => 'kategorija na bosanskom',
            'category_en' => 'kategorija na engleskom',
            'excerpt_bs' => 'sažetak na bosanskom',
            'excerpt_en' => 'sažetak na engleskom',
            'body_bs' => 'sadržaj na bosanskom',
            'body_en' => 'sadržaj na engleskom',
            'image' => 'naslovna slika',
            'image_alt_bs' => 'opis slike na bosanskom',
            'image_alt_en' => 'opis slike na engleskom',
            'status' => 'status',
            'published_at' => 'datum objave',
        ];
    }
}
