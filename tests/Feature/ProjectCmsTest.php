<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProjectCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_manage_projects(): void
    {
        $this->get('/admin/projects')->assertRedirect('/login');
        $this->post('/admin/projects')->assertRedirect('/login');

        $this->actingAs(User::factory()->create(['role' => User::ROLE_MEMBER]));
        $this->get('/admin/projects')->assertForbidden();
        $this->get('/admin/projects/create')->assertForbidden();
        $this->post('/admin/projects')->assertForbidden();
    }

    public function test_administrator_can_create_publish_update_and_delete_a_project(): void
    {
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($administrator)
            ->post('/admin/projects', $this->projectData())
            ->assertRedirect('/admin/projects');

        $project = Project::firstOrFail();
        $this->assertSame('Novi projekat', $project->title_bs);
        $this->assertCount(2, $project->meta_bs);
        $this->get('/bs/projects')->assertDontSeeText('Novi projekat');

        $this->actingAs($administrator)
            ->put('/admin/projects/'.$project->id, $this->projectData([
                'status' => 'published',
                'summary_bs' => '<script>alert(1)</script>',
            ]))
            ->assertRedirect('/admin/projects');

        $this->get('/bs/projects')
            ->assertOk()
            ->assertSee('project-register-grid')
            ->assertSeeText('Novi projekat')
            ->assertSeeText('Trajanje')
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
        $this->get('/en/projects')
            ->assertOk()
            ->assertSeeText('New project')
            ->assertSeeText('Duration')
            ->assertDontSeeText('Novi projekat');

        $this->actingAs($administrator)->delete('/admin/projects/'.$project->id)->assertRedirect('/admin/projects');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_existing_static_projects_remain_visible_with_or_without_the_cms_table(): void
    {
        $this->get('/bs/projects')->assertOk()->assertSeeText('NANO-THINK')->assertSeeText('Budućnost Bosanske Posavine');
        Schema::drop('projects');
        $this->get('/bs/projects')->assertOk()->assertSeeText('NANO-THINK')->assertSeeText('Budućnost Bosanske Posavine');
    }

    public function test_super_admin_can_prepare_project_storage_from_the_panel(): void
    {
        Schema::drop('projects');
        $superAdmin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);

        $this->actingAs($superAdmin)->get('/admin/projects')->assertOk()->assertSeeText('Pripremi bazu');
        $this->actingAs($superAdmin)->post('/admin/projects/setup')->assertRedirect('/admin/projects');
        $this->assertTrue(Schema::hasTable('projects'));
    }

    public function test_regular_admin_cannot_run_project_storage_setup(): void
    {
        Schema::drop('projects');
        $administrator = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($administrator)->post('/admin/projects/setup')->assertForbidden();
    }

    private function projectData(array $overrides = []): array
    {
        return array_replace_recursive([
            'title_bs' => 'Novi projekat',
            'title_en' => 'New project',
            'kind_bs' => 'Međunarodni projekat',
            'kind_en' => 'International project',
            'programme_bs' => 'ERASMUS+',
            'programme_en' => 'ERASMUS+',
            'summary_bs' => 'Opis novog projekta.',
            'summary_en' => 'New project description.',
            'meta_bs' => [
                ['label' => 'Trajanje', 'value' => '24 mjeseca'],
                ['label' => 'Partneri', 'value' => 'Pet institucija'],
                ['label' => '', 'value' => ''],
                ['label' => '', 'value' => ''],
            ],
            'meta_en' => [
                ['label' => 'Duration', 'value' => '24 months'],
                ['label' => 'Partners', 'value' => 'Five institutions'],
                ['label' => '', 'value' => ''],
                ['label' => '', 'value' => ''],
            ],
            'project_status' => 'active',
            'status' => 'draft',
            'sort_order' => 10,
        ], $overrides);
    }
}
