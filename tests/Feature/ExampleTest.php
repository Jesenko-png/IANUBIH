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
        $this->get('/bs')->assertOk()->assertSee('IANUBIH');
        $this->get('/en')->assertOk()->assertSee('IANUBIH');
    }
}
