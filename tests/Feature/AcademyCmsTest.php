<?php

namespace Tests\Feature;

use App\Models\AcademyPage;
use App\Models\User;
use App\Services\AcademyContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AcademyCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admins_can_read_and_write_academy_content(): void
    {
        $this->get('/admin/academy')->assertRedirect('/login');
        $this->put('/admin/academy/history')->assertRedirect('/login');
        $this->actingAs(User::factory()->create(['role' => User::ROLE_MEMBER]));
        $this->get('/admin/academy')->assertForbidden();
        $this->get('/admin/academy/history/edit')->assertForbidden();
        $this->put('/admin/academy/history')->assertForbidden();
    }

    public function test_admin_can_edit_both_languages_without_changing_other_pages(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $this->get('/admin/academy')->assertOk();
        $this->get('/admin/academy/about/edit')
            ->assertOk()
            ->assertSeeText('Vizuelni editor stranice')
            ->assertSee('data-language-button="en"', false)
            ->assertSee('academy-section-bs-hero', false)
            ->assertSee('content[bs][hero__title]', false)
            ->assertDontSee('content[bs][0]', false);
        $this->put('/admin/academy/history', ['content' => [
            'bs' => ['title' => 'Historija akademije', 'body' => "Prvi odlomak.\nDrugi odlomak. <script>alert(1)</script>"],
            'en' => ['title' => 'Academy history', 'body' => 'English history.'],
        ]])->assertRedirect('/admin/academy/history/edit');

        $this->get('/bs/academy/history')->assertOk()->assertSeeText('Historija akademije')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
        $this->get('/en/academy/history')->assertOk()->assertSeeText('English history.')->assertDontSeeText('Prvi odlomak.');
        $this->get('/bs/academy/statute')->assertOk()->assertDontSeeText('Prvi odlomak.');
        $this->assertDatabaseCount('academy_pages', 2);
        $this->get('/admin/academy/unknown/edit')->assertNotFound();
        $this->put('/admin/academy/unknown')->assertNotFound();
    }

    public function test_about_edits_preserve_structure_and_support_additional_content(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $content = [];
        foreach (['bs', 'en'] as $locale) {
            foreach (app(AcademyContent::class)->fields('about', $locale) as $key => $value) {
                $content[$locale][str_replace('.', '__', $key)] = $value;
            }
        }
        $content['bs']['hero__title'] = 'Novi naslov akademije';
        $content['bs']['additional_title'] = 'Dodatna sekcija';
        $content['bs']['additional_body'] = 'Novi sadržaj akademije.';
        $this->put('/admin/academy/about', compact('content'))->assertSessionHasNoErrors()->assertRedirect();
        $this->get('/bs/about')->assertOk()->assertSeeText('Novi naslov akademije')->assertSeeText('Novi sadržaj akademije.')
            ->assertSee('fa-star-o')->assertSee('mission-section');
        $this->get('/en/about')->assertOk()->assertDontSeeText('Novi naslov akademije');
    }

    public function test_invalid_content_does_not_partially_overwrite_saved_pages(): void
    {
        AcademyPage::create(['slug' => 'history', 'locale' => 'bs', 'content' => ['title' => 'Original', 'body' => 'Original body']]);
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $this->put('/admin/academy/history', ['content' => ['bs' => ['title' => 'Changed', 'body' => ['invalid']]]])
            ->assertSessionHasErrors();
        $this->assertSame('Original', AcademyPage::first()->content['title']);
    }

    public function test_public_pages_still_work_before_the_cms_migration(): void
    {
        Schema::drop('academy_pages');
        $this->get('/bs/about')->assertOk()->assertSeeText(trans('about.hero.title', [], 'bs'));
        $this->get('/en/academy/history')->assertOk();
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $this->get('/admin/academy')->assertOk()->assertSeeText(trans('academy_cms.setup'));
        $this->get('/admin/academy/history/edit')->assertStatus(503);
    }
}
