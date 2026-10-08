<?php

namespace Tests\Feature;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_list_and_editor_follow_selected_admin_language(): void
    {
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $post = NewsPost::create($this->postData());

        $this->actingAs($administrator)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.news.index'))
            ->assertOk()
            ->assertSee('lang="en"', false)
            ->assertSeeText('News')
            ->assertSeeText('New article')
            ->assertSeeText('English administration title')
            ->assertSeeText('English category')
            ->assertDontSeeText('Bosanski administracijski naslov');

        $this->actingAs($administrator)
            ->get(route('admin.news.create'))
            ->assertOk()
            ->assertSeeText('Bosnian content')
            ->assertSeeText('English content')
            ->assertSeeText('Publication')
            ->assertSeeText('Save article');

        $this->actingAs($administrator)
            ->get(route('admin.news.edit', ['newsPost' => $post]))
            ->assertOk()
            ->assertSeeText('Edit article');

        $this->actingAs($administrator)
            ->get(route('admin.news.index', ['locale' => 'bs']))
            ->assertOk()
            ->assertSessionHas('locale', 'bs')
            ->assertSee('lang="bs"', false)
            ->assertSeeText('Aktuelnosti')
            ->assertSeeText('Nova vijest')
            ->assertSeeText('Bosanski administracijski naslov')
            ->assertSeeText('Bosanska kategorija')
            ->assertDontSeeText('English administration title');

        $this->actingAs($administrator)
            ->get(route('admin.news.create'))
            ->assertOk()
            ->assertSeeText('Bosanski sadržaj')
            ->assertSeeText('Objava')
            ->assertSeeText('Sačuvaj vijest');
    }

    public function test_users_page_and_role_update_follow_selected_admin_language(): void
    {
        $superAdministrator = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);
        $member = User::factory()->create(['role' => User::ROLE_MEMBER]);

        $this->actingAs($superAdministrator)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('lang="en"', false)
            ->assertSeeText('Users')
            ->assertSeeText('Permissions')
            ->assertSeeText('Chief administrator')
            ->assertSeeText('Save permission');

        $this->actingAs($superAdministrator)
            ->patch(route('admin.users.update', ['user' => $member]), [
                'role' => User::ROLE_ADMIN,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', 'Administration access has been granted to the user.');

        $this->actingAs($superAdministrator)
            ->get(route('admin.users.index', ['locale' => 'bs']))
            ->assertOk()
            ->assertSessionHas('locale', 'bs')
            ->assertSee('lang="bs"', false)
            ->assertSeeText('Korisnici')
            ->assertSeeText('Dozvole')
            ->assertSeeText('Glavni administrator')
            ->assertSeeText('Sačuvaj dozvolu');

        $this->actingAs($superAdministrator)
            ->patch(route('admin.users.update', ['user' => $member]), [
                'role' => User::ROLE_MEMBER,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', 'Administratorsko pravo je uklonjeno.');
    }

    public function test_news_validation_uses_selected_admin_language(): void
    {
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($administrator)
            ->withSession(['locale' => 'en'])
            ->post(route('admin.news.store'), [])
            ->assertSessionHasErrors([
                'title_bs' => 'The Bosnian title field is required.',
                'title_en' => 'The English title field is required.',
            ]);

        $this->actingAs($administrator)
            ->get(route('admin.news.create', ['locale' => 'bs']))
            ->assertSessionHas('locale', 'bs');

        $this->actingAs($administrator)
            ->post(route('admin.news.store'), [])
            ->assertSessionHasErrors([
                'title_bs' => 'Polje naslov na bosanskom je obavezno.',
                'title_en' => 'Polje naslov na engleskom je obavezno.',
            ]);
    }

    public function test_analytics_page_is_available_to_administrators_in_both_languages(): void
    {
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($administrator)
            ->withSession(['locale' => 'bs'])
            ->get(route('admin.analytics.index'))
            ->assertOk()
            ->assertSeeText('Google Analytics')
            ->assertSeeText('Mjerenje je ugrađeno u javnu stranicu')
            ->assertDontSee('G-2KJZQ71XQX');

        $this->actingAs($administrator)
            ->get(route('admin.analytics.index', ['locale' => 'en']))
            ->assertOk()
            ->assertSeeText('Measurement is installed on the public website')
            ->assertSee('https://analytics.google.com/analytics/web/');
    }

    public function test_super_administrator_can_promote_another_user_but_cannot_change_own_role(): void
    {
        $superAdministrator = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);
        $member = User::factory()->create(['role' => User::ROLE_MEMBER]);

        $this->actingAs($superAdministrator)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('value="super_admin"', false);

        $this->actingAs($superAdministrator)
            ->patch(route('admin.users.update', ['user' => $member]), [
                'role' => User::ROLE_SUPER_ADMIN,
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status', 'Korisnik je postavljen za glavnog administratora.');

        $this->assertSame(User::ROLE_SUPER_ADMIN, $member->fresh()->role);

        $this->actingAs($member->fresh())
            ->get(route('admin.users.index'))
            ->assertOk();

        $this->actingAs($superAdministrator)
            ->patch(route('admin.users.update', ['user' => $superAdministrator]), [
                'role' => User::ROLE_MEMBER,
            ])
            ->assertUnprocessable();

        $this->assertSame(User::ROLE_SUPER_ADMIN, $superAdministrator->fresh()->role);
    }

    private function postData(): array
    {
        return [
            'created_by' => null,
            'slug' => 'dvojezicna-administracijska-vijest',
            'title_bs' => 'Bosanski administracijski naslov',
            'title_en' => 'English administration title',
            'category_bs' => 'Bosanska kategorija',
            'category_en' => 'English category',
            'excerpt_bs' => 'Bosanski sažetak administracijske vijesti.',
            'excerpt_en' => 'English administration news summary.',
            'body_bs' => 'Bosanski sadržaj administracijske vijesti.',
            'body_en' => 'English administration news content.',
            'image_path' => 'news/test.jpg',
            'image_alt_bs' => 'Opis slike',
            'image_alt_en' => 'Image description',
            'status' => 'draft',
            'published_at' => null,
        ];
    }
}
