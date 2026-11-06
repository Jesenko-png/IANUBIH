<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SectionPageController extends Controller
{
    public function academy(string $locale, string $topic): View
    {
        return $this->render('academy', $topic);
    }

    public function members(string $locale, string $topic): View
    {
        return $this->render('members', $topic);
    }

    public function organizationIndex(string $locale): View
    {
        return $this->render('organization', 'overview');
    }

    public function organization(string $locale, string $topic, ?string $item = null): View
    {
        return $this->render('organization', $topic, $item);
    }

    public function publications(string $locale, string $topic): View
    {
        return $this->render('publications', $topic);
    }

    public function cooperation(string $locale, string $topic): View
    {
        return $this->render('cooperation', $topic);
    }

    public function awards(string $locale): View
    {
        return $this->render('awards', 'overview');
    }

    private function render(string $section, string $topic, ?string $item = null): View
    {
        $pages = config('academy_pages.'.$section, []);
        abort_unless(array_key_exists($topic, $pages), 404);

        if ($item !== null) {
            abort_unless(is_array($pages[$topic]) && array_key_exists($item, $pages[$topic]), 404);
        }

        $titleKey = 'sections.pages.'.$section.'.'.$topic;
        $titleKey .= $item === null ? '.title' : '.children.'.$item;

        return view('pages.section', [
            'section' => $section,
            'topic' => $topic,
            'item' => $item,
            'title' => __($titleKey),
        ]);
    }
}
