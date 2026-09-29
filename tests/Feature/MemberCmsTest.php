<?php

namespace Tests\Feature;

use App\Models\AcademyMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_manage_members(): void
    {
        $this->get(route('admin.members.index'))->assertRedirect(route('login'));

        $reader = User::factory()->create(['role' => User::ROLE_MEMBER]);
        $this->actingAs($reader)->get(route('admin.members.index'))->assertForbidden();

        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($administrator)
            ->get(route('admin.members.index'))
            ->assertOk()
            ->assertSeeText('Novi član');
    }

    public function test_administrator_can_create_publish_update_and_delete_a_member_with_photo(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($administrator)->post(route('admin.members.store'), [
            ...$this->memberData(),
            'photo' => new UploadedFile(
                public_path('assets/new-event/images/b-web.jpg'),
                'profil.jpg',
                'image/jpeg',
                null,
                true,
            ),
        ])->assertRedirect(route('admin.members.index'));

        $member = AcademyMember::firstOrFail();
        $this->assertSame('test-clan', $member->slug);
        Storage::disk('public')->assertExists($member->photo_path);
        $this->get('/bs/people')->assertDontSee('Test Član');
        $this->get('/bs/people/'.$member->slug)->assertNotFound();

        $this->actingAs($administrator)->put(route('admin.members.update', $member), [
            ...$this->memberData(['status' => 'published']),
            'remove_photo' => '1',
        ])->assertRedirect(route('admin.members.index'));

        Storage::disk('public')->assertMissing($member->photo_path);
        $member->refresh();
        $this->assertNull($member->photo_path);
        $this->get('/bs/people')
            ->assertOk()
            ->assertSeeText('Test Član')
            ->assertSeeText('Medicinske nauke');
        $this->get('/en/people')
            ->assertOk()
            ->assertSeeText('Medical sciences');
        $this->get('/bs/people/'.$member->slug)
            ->assertOk()
            ->assertSeeText('Biografija člana.');
        $this->get('/bs/people?q=Medicinske')
            ->assertOk()
            ->assertSeeText('Test Član');
        $this->get('/bs/people?q=Nepostojeće')
            ->assertOk()
            ->assertDontSeeText('Test Član');

        $this->actingAs($administrator)
            ->delete(route('admin.members.destroy', $member))
            ->assertRedirect(route('admin.members.index'));

        $this->assertDatabaseMissing('academy_members', ['id' => $member->id]);
    }

    public function test_member_biography_is_escaped_on_the_public_page(): void
    {
        $member = AcademyMember::create([
            ...$this->memberData([
                'bio_bs' => '<script>alert(1)</script>',
                'status' => 'published',
            ]),
            'slug' => 'siguran-clan',
        ]);

        $this->get('/bs/people/'.$member->slug)
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_chief_administrator_can_prepare_missing_member_table_without_terminal(): void
    {
        Schema::dropIfExists('academy_members');
        $superAdministrator = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);

        $this->get('/bs/people')->assertOk();
        $this->actingAs($superAdministrator)
            ->get(route('admin.members.index'))
            ->assertOk()
            ->assertSeeText('Pripremi bazu članova');

        $this->actingAs($superAdministrator)
            ->post(route('admin.members.setup'))
            ->assertRedirect(route('admin.members.index'));

        $this->assertTrue(Schema::hasTable('academy_members'));
    }

    private function memberData(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Test Član',
            'academic_title' => 'Prof. dr.',
            'category_bs' => 'Redovni član',
            'category_en' => 'Regular member',
            'position_bs' => 'Istraživač',
            'position_en' => 'Researcher',
            'field_bs' => 'Medicinske nauke',
            'field_en' => 'Medical sciences',
            'institution_bs' => 'Univerzitet u Sarajevu',
            'institution_en' => 'University of Sarajevo',
            'country_bs' => 'Bosna i Hercegovina',
            'country_en' => 'Bosnia and Herzegovina',
            'bio_bs' => 'Biografija člana.',
            'bio_en' => 'Member biography.',
            'email' => 'clan@example.com',
            'website_url' => 'https://example.com',
            'status' => 'draft',
            'sort_order' => 0,
        ], $overrides);
    }
}
