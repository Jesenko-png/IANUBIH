<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademyPage;
use App\Services\AcademyContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AcademyPageController extends Controller
{
    public function index(AcademyContent $content): View
    {
        return view('admin.academy.index', ['pages' => $content->pages(), 'storageReady' => $content->ready()]);
    }

    public function edit(string $page, AcademyContent $content): View
    {
        abort_unless(in_array($page, $content->pages(), true), 404);
        abort_unless($content->ready(), 503, __('academy_cms.setup'));

        return view('admin.academy.edit', [
            'page' => $page,
            'contents' => collect(['bs', 'en'])->mapWithKeys(fn ($locale) => [$locale => Arr::dot($content->content($page, $locale))])->all(),
            'fields' => $content->fields($page, 'bs'),
        ]);
    }

    public function update(Request $request, string $page, AcademyContent $content): RedirectResponse
    {
        abort_unless(in_array($page, $content->pages(), true), 404);
        abort_unless($content->ready(), 503, __('academy_cms.setup'));
        $rules = [];
        foreach (['bs', 'en'] as $locale) {
            foreach ($content->fields($page, $locale) as $key => $default) {
                $rules['content.'.$locale.'.'.str_replace('.', '__', $key)] = [
                    in_array($key, ['title', 'hero.title', 'meta.title'], true) ? 'required' : 'present',
                    'nullable', 'string', 'max:50000',
                ];
            }
        }
        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $page) {
            foreach (['bs', 'en'] as $locale) {
                $values = [];
                foreach ($validated['content'][$locale] as $key => $value) {
                    Arr::set($values, str_replace('__', '.', $key), $value ?? '');
                }
                AcademyPage::updateOrCreate(['slug' => $page, 'locale' => $locale], ['content' => $values]);
            }
        });

        return redirect()->route('admin.academy.edit', $page)->with('status', __('academy_cms.saved'));
    }
}
