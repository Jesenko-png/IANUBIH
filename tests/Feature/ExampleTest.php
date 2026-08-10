<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_root_url_redirects_to_the_default_locale(): void
    {
        $this->get('/')->assertRedirect('/bs');
    }

    public function test_the_localized_home_pages_are_available(): void
    {
        $this->get('/bs')
            ->assertOk()
            ->assertSeeText('Znanje koje povezuje.')
            ->assertSeeText('Mudrost koja usmjerava.')
            ->assertSee('assets/new-event/css/ianubih.css')
            ->assertSee('assets/new-event/js/ianubih.js')
            ->assertDontSee('assets/new-event/js/smoothscroll.js')
            ->assertDontSeeText('Web Design Conference');

        $this->get('/en')
            ->assertOk()
            ->assertSeeText('Knowledge that connects.')
            ->assertSeeText('Wisdom that guides.')
            ->assertSee('assets/new-event/css/ianubih.css')
            ->assertSee('assets/new-event/js/ianubih.js')
            ->assertDontSee('assets/new-event/js/smoothscroll.js')
            ->assertDontSeeText('Web Design Conference');
    }

    public function test_the_about_page_is_fully_localized(): void
    {
        $this->get('/bs/about')
            ->assertOk()
            ->assertSeeText('Akademija koja povezuje znanje, iskustvo i odgovornost')
            ->assertSeeText('Naša misija')
            ->assertSeeText('Česta pitanja')
            ->assertSee(route('about', ['locale' => 'en']));

        $this->get('/en/about')
            ->assertOk()
            ->assertSeeText('An academy connecting knowledge, experience and responsibility')
            ->assertSeeText('Our mission')
            ->assertSeeText('Frequently asked questions')
            ->assertSee(route('about', ['locale' => 'bs']));
    }

    public function test_all_prepared_site_routes_are_available_in_both_languages(): void
    {
        $paths = [
            'people',
            'fields',
            'projects',
            'publications',
            'events',
            'news',
            'cooperation',
            'contact',
        ];

        foreach (['bs', 'en'] as $locale) {
            foreach ($paths as $path) {
                $this->get("/{$locale}/{$path}")->assertOk();
            }
        }
    }

    public function test_the_fields_page_contains_all_nine_areas_in_both_languages(): void
    {
        $bosnianAreas = [
            'Društvene nauke',
            'Medicinske nauke',
            'Humanističke nauke i kultura',
            'Tehničke i prirodno-matematičke nauke',
            'Umjetnost',
            'Religija i međukulturni dijalog',
            'Mladi naučnici',
            'Naučna dijaspora',
            'Održivi razvoj',
        ];

        $englishAreas = [
            'Social sciences',
            'Medical sciences',
            'Humanities and culture',
            'Technical, natural and mathematical sciences',
            'Arts',
            'Religion and intercultural dialogue',
            'Young scientists',
            'Scientific diaspora',
            'Sustainable development',
        ];

        $bosnianResponse = $this->get('/bs/fields')
            ->assertOk()
            ->assertSeeText('Znanje bez granica među disciplinama')
            ->assertSee(route('fields', ['locale' => 'en']));

        foreach ($bosnianAreas as $area) {
            $bosnianResponse->assertSeeText($area);
        }

        $englishResponse = $this->get('/en/fields')
            ->assertOk()
            ->assertSeeText('Knowledge without boundaries between disciplines')
            ->assertSee(route('fields', ['locale' => 'bs']));

        foreach ($englishAreas as $area) {
            $englishResponse->assertSeeText($area);
        }
    }

    public function test_the_projects_page_is_complete_and_localized(): void
    {
        $this->get('/bs/projects')
            ->assertOk()
            ->assertSeeText('Ideje koje povezuju znanje i djelovanje')
            ->assertSeeText('Četiri načina zajedničkog rada')
            ->assertSeeText('Sadržaj u pripremi')
            ->assertDontSeeText('Stranica u pripremi');

        $this->get('/en/projects')
            ->assertOk()
            ->assertSeeText('Ideas connecting knowledge and action')
            ->assertSeeText('Four ways of working together')
            ->assertSeeText('Content in preparation')
            ->assertDontSeeText('Page in preparation');
    }
}
