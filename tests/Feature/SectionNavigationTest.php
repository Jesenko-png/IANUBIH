<?php

namespace Tests\Feature;

use Tests\TestCase;

class SectionNavigationTest extends TestCase
{
    public function test_proposed_navigation_renders_without_contact_in_top_menu(): void
    {
        $response = $this->get('/bs/about');

        $response->assertOk()
            ->assertSee('O Akademiji')
            ->assertSee('Članovi')
            ->assertSee('Organizacija')
            ->assertSee('Nagrade')
            ->assertSee('Razredi')
            ->assertSee('Sarajevski ogranak')
            ->assertSee('href="'.route('contact', ['locale' => 'bs']).'"', false);

        $this->assertStringNotContainsString('nav-contact-link', $response->getContent());
    }

    public function test_all_proposed_content_pages_exist_in_both_languages(): void
    {
        foreach (['bs', 'en'] as $locale) {
            foreach (config('academy_pages') as $section => $topics) {
                foreach ($topics as $topic => $children) {
                    $url = $this->urlFor($locale, $section, $topic);
                    $this->get($url)->assertOk();

                    if (is_array($children)) {
                        foreach (array_keys($children) as $item) {
                            $this->get($this->urlFor($locale, $section, $topic, $item))->assertOk();
                        }
                    }
                }
            }
        }
    }

    public function test_unknown_content_pages_return_404(): void
    {
        $this->get('/bs/academy/not-a-page')->assertNotFound();
        $this->get('/bs/organization/divisions/not-a-division')->assertNotFound();
        $this->get('/bs/organization/board/not-a-child')->assertNotFound();
    }

    private function urlFor(string $locale, string $section, string $topic, ?string $item = null): string
    {
        return match ($section) {
            'academy' => route('academy.topic', compact('locale', 'topic')),
            'members' => route('members.topic', compact('locale', 'topic')),
            'organization' => $topic === 'overview'
                ? route('organization', compact('locale'))
                : route('organization.topic', array_filter(compact('locale', 'topic', 'item'))),
            'publications' => route('publications.topic', compact('locale', 'topic')),
            'cooperation' => route('cooperation.topic', compact('locale', 'topic')),
            'awards' => route('awards', compact('locale')),
        };
    }
}
