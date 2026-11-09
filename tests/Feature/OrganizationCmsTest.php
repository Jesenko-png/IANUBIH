<?php

namespace Tests\Feature;

use App\Models\AcademyPage;
use App\Models\User;
use App\Services\OrganizationContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrganizationCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_manage_organization_content(): void
    {
        $this->get('/admin/organization')->assertRedirect('/login');
        $this->put('/admin/organization/board')->assertRedirect('/login');

        $this->actingAs(User::factory()->create(['role' => User::ROLE_MEMBER]));
        $this->get('/admin/organization')->assertForbidden();
        $this->get('/admin/organization/board')->assertForbidden();
        $this->put('/admin/organization/board')->assertForbidden();
    }

    public function test_admin_can_edit_all_organization_pages_in_both_languages(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));

        $this->get('/admin/organization')
            ->assertOk()
            ->assertSeeText('Uprava')
            ->assertSeeText('Razred za društvene znanosti')
            ->assertSeeText('Mostarski ogranak');

        $this->get('/admin/organization/divisions/social-sciences')
            ->assertOk()
            ->assertSee('content[bs][title]', false)
            ->assertSee('content[en][body]', false);

        $this->put('/admin/organization/divisions/social-sciences', ['content' => [
            'bs' => ['title' => 'Društvene nauke', 'body' => "Sadržaj razreda.\nDrugi red."],
            'en' => ['title' => 'Social Sciences', 'body' => 'Division content.'],
        ]])->assertRedirect('/admin/organization/divisions/social-sciences');

        $this->get('/bs/organization/divisions/social-sciences')
            ->assertOk()->assertSeeText('Društvene nauke')->assertSeeText('Sadržaj razreda.');
        $this->get('/en/organization/divisions/social-sciences')
            ->assertOk()->assertSeeText('Social Sciences')->assertSeeText('Division content.')
            ->assertDontSeeText('Sadržaj razreda.');
        $this->get('/bs/organization/divisions')
            ->assertOk()->assertSeeText('Društvene nauke');
    }

    public function test_saved_page_titles_are_used_on_the_organization_overview(): void
    {
        AcademyPage::create([
            'slug' => 'organization:board',
            'locale' => 'bs',
            'content' => ['title' => 'Novo ime uprave', 'body' => ''],
        ]);

        $this->get('/bs/organization')->assertOk()->assertSeeText('Novo ime uprave');
        $this->get('/en/organization')->assertOk()->assertDontSeeText('Novo ime uprave');
    }

    public function test_admin_can_edit_president_profile_and_photo_safely(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $service = app(OrganizationContent::class);
        $content = [];

        foreach (['bs', 'en'] as $locale) {
            foreach ($service->fields('presidency', null, $locale) as $key => $value) {
                $content[$locale][str_replace('.', '__', $key)] = $value;
            }
        }

        $content['bs']['name'] = 'Novo ime predsjednika';
        $content['bs']['bio'] = '<script>alert(1)</script>';

        $this->put('/admin/organization/presidency', [
            'content' => $content,
            'photo' => new UploadedFile(
                public_path('assets/new-event/images/b-web.jpg'),
                'predsjednik.jpg',
                'image/jpeg',
                null,
                true,
            ),
        ])->assertSessionHasNoErrors()->assertRedirect('/admin/organization/presidency');

        $page = AcademyPage::where('slug', 'organization:presidency')->where('locale', 'bs')->firstOrFail();
        Storage::disk('public')->assertExists($page->content['image_path']);
        $this->get('/bs/organization/presidency')
            ->assertOk()
            ->assertSeeText('Novo ime predsjednika')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee(Storage::disk('public')->url($page->content['image_path']));
    }

    public function test_invalid_organization_pages_return_not_found(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($admin)->get('/admin/organization/not-a-page')->assertNotFound();
        $this->actingAs($admin)->get('/admin/organization/board/not-a-child')->assertNotFound();
        $this->actingAs($admin)->put('/admin/organization/not-a-page')->assertNotFound();
    }

    public function test_public_organization_pages_keep_their_defaults_without_cms_storage(): void
    {
        Schema::drop('academy_pages');

        $this->get('/bs/organization')->assertOk()->assertSeeText('Uprava');
        $this->get('/en/organization/presidency')->assertOk()->assertSeeText('Academician Prof. Dr. Almir Badnjević');

        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));
        $this->get('/admin/organization')->assertOk()->assertSeeText(trans('organization_cms.setup'));
        $this->get('/admin/organization/board')->assertStatus(503);
    }
}
