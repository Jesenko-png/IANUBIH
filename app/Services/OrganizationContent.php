<?php

namespace App\Services;

use App\Models\AcademyPage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class OrganizationContent
{
    public function ready(): bool
    {
        return Schema::hasTable('academy_pages');
    }

    public function pages(): array
    {
        $pages = [];

        foreach (config('academy_pages.organization', []) as $topic => $children) {
            $pages[] = ['topic' => $topic, 'item' => null];

            if (is_array($children)) {
                foreach (array_keys($children) as $item) {
                    $pages[] = ['topic' => $topic, 'item' => $item];
                }
            }
        }

        return $pages;
    }

    public function exists(string $topic, ?string $item = null): bool
    {
        $topics = config('academy_pages.organization', []);

        if (! array_key_exists($topic, $topics)) {
            return false;
        }

        return $item === null || (is_array($topics[$topic]) && array_key_exists($item, $topics[$topic]));
    }

    public function storageKey(string $topic, ?string $item = null): string
    {
        return 'organization:'.$topic.($item === null ? '' : ':'.$item);
    }

    public function defaults(string $topic, ?string $item, string $locale): array
    {
        $base = 'sections.pages.organization.'.$topic;
        $title = $item === null
            ? trans($base.'.title', [], $locale)
            : trans($base.'.children.'.$item, [], $locale);

        if ($topic === 'presidency' && $item === null) {
            return [
                ...trans($base, [], $locale),
                'image_path' => 'news/almir-badnjevic-predsjednik-iasabih.jpeg',
            ];
        }

        return ['title' => $title, 'body' => ''];
    }

    public function content(string $topic, ?string $item, string $locale): array
    {
        $saved = $this->ready()
            ? AcademyPage::where('slug', $this->storageKey($topic, $item))->where('locale', $locale)->value('content')
            : [];

        return array_replace_recursive($this->defaults($topic, $item, $locale), $saved ?? []);
    }

    public function fields(string $topic, ?string $item, string $locale): array
    {
        return array_filter(
            Arr::dot($this->defaults($topic, $item, $locale)),
            fn ($value, $key) => is_string($value) && $key !== 'image_path',
            ARRAY_FILTER_USE_BOTH,
        );
    }

    public function links(string $topic, string $locale): array
    {
        if ($topic === 'overview') {
            return collect(config('academy_pages.organization'))
                ->except('overview')
                ->keys()
                ->map(fn ($childTopic) => [
                    'topic' => $childTopic,
                    'item' => null,
                    'title' => $this->content($childTopic, null, $locale)['title'],
                ])->all();
        }

        $children = config('academy_pages.organization.'.$topic);

        if (! is_array($children)) {
            return [];
        }

        return collect(array_keys($children))->map(fn ($item) => [
            'topic' => $topic,
            'item' => $item,
            'title' => $this->content($topic, $item, $locale)['title'],
        ])->all();
    }
}
