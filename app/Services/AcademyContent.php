<?php

namespace App\Services;

use App\Models\AcademyPage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class AcademyContent
{
    public function ready(): bool
    {
        return Schema::hasTable('academy_pages');
    }

    public function pages(): array
    {
        return ['about', ...array_keys(config('academy_pages.academy', []))];
    }

    public function defaults(string $slug, string $locale): array
    {
        if ($slug === 'about') {
            return [...trans('about', [], $locale), 'additional_title' => '', 'additional_body' => ''];
        }

        return ['title' => trans('sections.pages.academy.'.$slug.'.title', [], $locale), 'body' => ''];
    }

    public function content(string $slug, string $locale): array
    {
        $saved = $this->ready()
            ? AcademyPage::where('slug', $slug)->where('locale', $locale)->value('content')
            : [];

        return array_replace_recursive($this->defaults($slug, $locale), $saved ?? []);
    }

    public function fields(string $slug, string $locale): array
    {
        return array_filter(Arr::dot($this->defaults($slug, $locale)),
            fn ($value, $key) => is_string($value) && ! str_ends_with($key, '.icon'), ARRAY_FILTER_USE_BOTH);
    }
}
