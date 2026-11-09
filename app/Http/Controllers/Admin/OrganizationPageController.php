<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademyPage;
use App\Services\OrganizationContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class OrganizationPageController extends Controller
{
    public function index(OrganizationContent $content): View
    {
        return view('admin.organization.index', [
            'pages' => collect($content->pages())->map(fn ($page) => [
                ...$page,
                'title' => $content->content($page['topic'], $page['item'], app()->getLocale())['title'],
            ])->all(),
            'storageReady' => $content->ready(),
        ]);
    }

    public function edit(OrganizationContent $content, string $topic, ?string $item = null): View
    {
        abort_unless($content->exists($topic, $item), 404);
        abort_unless($content->ready(), 503, __('organization_cms.setup'));

        return view('admin.organization.edit', [
            'topic' => $topic,
            'item' => $item,
            'contents' => collect(['bs', 'en'])->mapWithKeys(
                fn ($locale) => [$locale => Arr::dot($content->content($topic, $item, $locale))]
            )->all(),
            'fields' => $content->fields($topic, $item, 'bs'),
            'imagePath' => $content->content($topic, $item, 'bs')['image_path'] ?? null,
        ]);
    }

    public function update(Request $request, OrganizationContent $content, string $topic, ?string $item = null): RedirectResponse
    {
        abort_unless($content->exists($topic, $item), 404);
        abort_unless($content->ready(), 503, __('organization_cms.setup'));

        $rules = [
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_photo' => ['nullable', 'boolean'],
        ];

        foreach (['bs', 'en'] as $locale) {
            foreach ($content->fields($topic, $item, $locale) as $key => $default) {
                $rules['content.'.$locale.'.'.str_replace('.', '__', $key)] = [
                    $key === 'title' ? 'required' : 'present',
                    'nullable', 'string', 'max:50000',
                ];
            }
        }

        $validated = $request->validate($rules);
        $isPresidency = $topic === 'presidency' && $item === null;
        $oldPhoto = $isPresidency ? ($content->content($topic, $item, 'bs')['image_path'] ?? null) : null;
        $newPhoto = $isPresidency ? $request->file('photo')?->store('organization', 'public') : null;
        $removePhoto = $isPresidency && $request->boolean('remove_photo');

        try {
            DB::transaction(function () use ($validated, $topic, $item, $content, $oldPhoto, $newPhoto, $removePhoto, $isPresidency) {
                foreach (['bs', 'en'] as $locale) {
                    $values = [];
                    foreach ($validated['content'][$locale] as $key => $value) {
                        Arr::set($values, str_replace('__', '.', $key), $value ?? '');
                    }

                    if ($isPresidency) {
                        $values['image_path'] = $newPhoto ?: ($removePhoto ? null : $oldPhoto);
                    }

                    AcademyPage::updateOrCreate(
                        ['slug' => $content->storageKey($topic, $item), 'locale' => $locale],
                        ['content' => $values],
                    );
                }
            });
        } catch (Throwable $exception) {
            if ($newPhoto) {
                Storage::disk('public')->delete($newPhoto);
            }

            throw $exception;
        }

        if (($newPhoto || $removePhoto) && $oldPhoto && ! str_starts_with($oldPhoto, 'news/')) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()->route('admin.organization.edit', array_filter(compact('topic', 'item')))
            ->with('status', __('organization_cms.saved'));
    }
}
