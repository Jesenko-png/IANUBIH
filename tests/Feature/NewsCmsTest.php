<?php

namespace Tests\Feature;

use App\Models\NewsPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_show_only_currently_published_news(): void
    {
        $published = NewsPost::create($this->postData([
            'slug' => 'objavljena-vijest',
            'title_bs' => 'Objavljena vijest',
            'title_en' => 'Published news',
            'status' => 'published',
            'published_at' => now()->subHour(),
        ]));
        NewsPost::create($this->postData([
            'slug' => 'nacrt-vijest',
            'title_bs' => 'Nacrt vijest',
            'status' => 'draft',
            'published_at' => null,
        ]));
        NewsPost::create($this->postData([
            'slug' => 'zakazana-vijest',
            'title_bs' => 'Zakazana vijest',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]));

        $this->get('/bs/news')
            ->assertOk()
            ->assertSee($published->title_bs)
            ->assertDontSee('Nacrt vijest')
            ->assertDontSee('Zakazana vijest');

        $this->get('/bs')
            ->assertOk()
            ->assertSee($published->title_bs)
            ->assertDontSee('Nacrt vijest')
            ->assertDontSee('Zakazana vijest');

        $this->get('/en/news/'.$published->slug)
            ->assertOk()
            ->assertSee('Published news');
    }

    public function test_draft_and_scheduled_news_cannot_be_opened_publicly(): void
    {
        $draft = NewsPost::create($this->postData([
            'slug' => 'privatni-nacrt',
            'status' => 'draft',
            'published_at' => null,
        ]));
        $scheduled = NewsPost::create($this->postData([
            'slug' => 'buduca-objava',
            'status' => 'published',
            'published_at' => now()->addHour(),
        ]));

        $this->get('/bs/news/'.$draft->slug)->assertNotFound();
        $this->get('/bs/news/'.$scheduled->slug)->assertNotFound();
    }

    public function test_guest_cannot_access_news_administration(): void
    {
        $this->get('/admin/news')->assertRedirect('/login');
        $this->get('/admin/news/create')->assertRedirect('/login');
        $this->get('/admin/login')->assertNotFound();
    }

    public function test_first_account_becomes_super_admin_and_later_accounts_require_approval(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('register-disclosure')
            ->assertSeeText('Kreiraj nalog')
            ->assertSee(route('register'));

        $this->post(route('register'), [
            'name' => 'IANUBIH Administrator',
            'register_email' => 'admin@ianubih.ba',
            'register_password' => 'SigurnaLozinka2026',
            'register_password_confirmation' => 'SigurnaLozinka2026',
        ])->assertRedirect(route('admin.news.index'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'IANUBIH Administrator',
            'email' => 'admin@ianubih.ba',
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $this->post(route('logout'))->assertRedirect(route('login'));

        $this->get('/login')
            ->assertOk()
            ->assertSee('register-disclosure')
            ->assertSeeText('Kreiraj nalog');

        $this->post(route('register'), [
            'name' => 'Novi korisnik',
            'register_email' => 'drugi@ianubih.ba',
            'register_password' => 'DrugaLozinka2026',
            'register_password_confirmation' => 'DrugaLozinka2026',
        ])->assertRedirect(route('account.show'));

        $this->assertDatabaseHas('users', [
            'email' => 'drugi@ianubih.ba',
            'role' => User::ROLE_MEMBER,
        ]);
        $this->assertDatabaseCount('users', 2);
        $this->get('/account')->assertOk()->assertSeeText('čeka administratorsko odobrenje');
        $this->get('/admin/news')->assertForbidden();
    }

    public function test_public_navigation_contains_the_login_button(): void
    {
        $this->get('/bs')
            ->assertOk()
            ->assertSee(route('login'))
            ->assertSeeText('Prijava');

        $this->get('/en')
            ->assertOk()
            ->assertSee(route('login'))
            ->assertSeeText('Login');
    }

    public function test_only_super_admin_can_grant_news_administration_permission(): void
    {
        $superAdmin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $member = User::factory()->create(['role' => User::ROLE_MEMBER]);

        $this->actingAs($administrator)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee($member->email);

        $this->actingAs($superAdmin)
            ->patch(route('admin.users.update', $member), ['role' => User::ROLE_ADMIN])
            ->assertRedirect(route('admin.users.index'));

        $this->assertSame(User::ROLE_ADMIN, $member->fresh()->role);

        $this->actingAs($member->fresh())
            ->get(route('admin.news.index'))
            ->assertOk();
    }

    public function test_administrator_can_create_edit_and_delete_news_with_an_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $image = new UploadedFile(
            public_path('assets/new-event/images/b-web.jpg'),
            'akademija.jpg',
            'image/jpeg',
            null,
            true,
        );

        $response = $this->actingAs($admin)->post(route('admin.news.store'), [
            'title_bs' => 'Nova vijest Akademije',
            'title_en' => 'New Academy story',
            'category_bs' => 'Saopćenje',
            'category_en' => 'Announcement',
            'excerpt_bs' => 'Sažetak nove vijesti na bosanskom jeziku.',
            'excerpt_en' => 'A summary of the new story in English.',
            'body_bs' => "Prvi pasus.\n\nDrugi pasus.",
            'body_en' => "First paragraph.\n\nSecond paragraph.",
            'image' => $image,
            'image_alt_bs' => 'Članovi Akademije',
            'image_alt_en' => 'Academy members',
            'status' => 'published',
            'published_at' => '',
        ]);

        $response->assertRedirect(route('admin.news.index'));
        $post = NewsPost::sole();
        $this->assertSame('nova-vijest-akademije', $post->slug);
        $this->assertTrue($post->isPublished());
        Storage::disk('public')->assertExists($post->image_path);

        $this->actingAs($admin)->put(route('admin.news.update', $post), [
            'title_bs' => 'Uređena vijest Akademije',
            'title_en' => 'Edited Academy story',
            'category_bs' => 'Saopćenje',
            'category_en' => 'Announcement',
            'excerpt_bs' => 'Uređeni sažetak na bosanskom jeziku.',
            'excerpt_en' => 'An edited summary in English.',
            'body_bs' => 'Uređeni sadržaj.',
            'body_en' => 'Edited content.',
            'image_alt_bs' => 'Članovi Akademije',
            'image_alt_en' => 'Academy members',
            'status' => 'draft',
            'published_at' => '',
        ])->assertRedirect(route('admin.news.index'));

        $post->refresh();
        $this->assertSame('Uređena vijest Akademije', $post->title_bs);
        $this->assertSame('nova-vijest-akademije', $post->slug);
        $this->assertSame('draft', $post->status);
        $this->assertNull($post->published_at);

        $imagePath = $post->image_path;
        $this->actingAs($admin)
            ->delete(route('admin.news.destroy', $post))
            ->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseMissing('news_posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_news_body_is_rendered_as_text_instead_of_executable_html(): void
    {
        $post = NewsPost::create($this->postData([
            'slug' => 'sigurna-vijest',
            'status' => 'published',
            'published_at' => now()->subMinute(),
            'body_bs' => '<script>alert("xss")</script>',
        ]));

        $this->get('/bs/news/'.$post->slug)
            ->assertOk()
            ->assertDontSee('<script>', false)
            ->assertSee('&lt;script&gt;', false);
    }

    private function postData(array $overrides = []): array
    {
        return array_merge([
            'created_by' => null,
            'slug' => 'test-vijest-'.uniqid(),
            'title_bs' => 'Test vijest',
            'title_en' => 'Test news',
            'category_bs' => 'Aktuelnosti',
            'category_en' => 'News',
            'excerpt_bs' => 'Sažetak vijesti na bosanskom jeziku.',
            'excerpt_en' => 'A summary of the news item in English.',
            'body_bs' => 'Sadržaj vijesti na bosanskom jeziku.',
            'body_en' => 'The news content in English.',
            'image_path' => 'news/test.jpg',
            'image_alt_bs' => 'Opis slike',
            'image_alt_en' => 'Image description',
            'status' => 'draft',
            'published_at' => null,
        ], $overrides);
    }
}
