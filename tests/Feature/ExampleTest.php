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
}
