<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class ProjectController extends Controller
{
    public function index(): View
    {
        $storageReady = Schema::hasTable('projects');
        $projects = $storageReady
            ? Project::query()->orderBy('sort_order')->orderByDesc('updated_at')->paginate(20)
            : new LengthAwarePaginator([], 0, 20);

        return view('admin.projects.index', compact('projects', 'storageReady'));
    }

    public function setup(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        if (Schema::hasTable('projects')) {
            return redirect()->route('admin.projects.index')->with('status', __('projects_cms.storage_already_ready'));
        }

        try {
            DB::table('migrations')->where('migration', '2026_11_09_000002_create_projects_table')->delete();
            $exitCode = Artisan::call('migrate', [
                '--force' => true,
                '--path' => 'database/migrations/2026_11_09_000002_create_projects_table.php',
            ]);

            if ($exitCode !== 0 || ! Schema::hasTable('projects')) {
                throw new \RuntimeException('The projects migration did not complete.');
            }
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('admin.projects.index')->withErrors(['storage' => __('projects_cms.storage_error')]);
        }

        return redirect()->route('admin.projects.index')->with('status', __('projects_cms.storage_ready'));
    }

    public function create(): View
    {
        abort_unless(Schema::hasTable('projects'), 503);

        return view('admin.projects.create');
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        Project::create([
            ...$this->normalizedData($request),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.projects.index')->with('status', __('projects_cms.saved'));
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($this->normalizedData($request));

        return redirect()->route('admin.projects.index')->with('status', __('projects_cms.updated'));
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('status', __('projects_cms.deleted'));
    }

    private function normalizedData(ProjectRequest $request): array
    {
        $validated = $request->validated();
        $data = Arr::except($validated, ['meta_bs', 'meta_en']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['meta_bs'] = $this->normalizeMeta($validated['meta_bs'] ?? []);
        $data['meta_en'] = $this->normalizeMeta($validated['meta_en'] ?? []);

        return $data;
    }

    private function normalizeMeta(array $rows): array
    {
        return collect($rows)
            ->map(fn ($row) => [
                'label' => trim((string) ($row['label'] ?? '')),
                'value' => trim((string) ($row['value'] ?? '')),
            ])
            ->filter(fn ($row) => $row['label'] !== '' || $row['value'] !== '')
            ->values()
            ->all();
    }
}
