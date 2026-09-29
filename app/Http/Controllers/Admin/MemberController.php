<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademyMemberRequest;
use App\Models\AcademyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class MemberController extends Controller
{
    public function index(): View
    {
        $storageReady = Schema::hasTable('academy_members');
        $members = $storageReady
            ? AcademyMember::query()->orderBy('sort_order')->orderBy('name')->paginate(20)
            : new LengthAwarePaginator([], 0, 20);

        return view('admin.members.index', compact('members', 'storageReady'));
    }

    public function setup(Request $request): RedirectResponse
    {
        abort_unless($request->user()->isSuperAdmin(), 403);

        if (Schema::hasTable('academy_members')) {
            return redirect()->route('admin.members.index')
                ->with('status', __('members.admin.storage_already_ready'));
        }

        try {
            if (Schema::hasTable('migrations')) {
                DB::table('migrations')
                    ->where('migration', '2026_09_29_000000_create_academy_members_table')
                    ->delete();
            }

            $exitCode = Artisan::call('migrate', [
                '--force' => true,
                '--path' => 'database/migrations/2026_09_29_000000_create_academy_members_table.php',
            ]);

            if ($exitCode !== 0 || ! Schema::hasTable('academy_members')) {
                throw new \RuntimeException('The academy members migration did not complete.');
            }
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('admin.members.index')
                ->withErrors(['storage' => __('members.admin.storage_error')]);
        }

        return redirect()->route('admin.members.index')
            ->with('status', __('members.admin.storage_ready'));
    }

    public function create(): View
    {
        abort_unless(Schema::hasTable('academy_members'), 503);

        return view('admin.members.create');
    }

    public function store(AcademyMemberRequest $request): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['photo', 'remove_photo']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $photoPath = $request->file('photo')?->store('members', 'public');

        try {
            AcademyMember::create([
                ...$data,
                'slug' => $this->uniqueSlug($data['name']),
                'photo_path' => $photoPath,
                'created_by' => $request->user()->id,
            ]);
        } catch (Throwable $exception) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            throw $exception;
        }

        return redirect()->route('admin.members.index')
            ->with('status', __('members.admin.saved'));
    }

    public function edit(AcademyMember $member): View
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(AcademyMemberRequest $request, AcademyMember $member): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['photo', 'remove_photo']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $oldPhoto = $member->photo_path;
        $newPhoto = $request->file('photo')?->store('members', 'public');

        if ($newPhoto) {
            $data['photo_path'] = $newPhoto;
        } elseif ($request->boolean('remove_photo')) {
            $data['photo_path'] = null;
        }

        try {
            $member->update($data);
        } catch (Throwable $exception) {
            if ($newPhoto) {
                Storage::disk('public')->delete($newPhoto);
            }

            throw $exception;
        }

        if ($oldPhoto && array_key_exists('photo_path', $data)) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()->route('admin.members.index')
            ->with('status', __('members.admin.updated'));
    }

    public function destroy(AcademyMember $member): RedirectResponse
    {
        $photoPath = $member->photo_path;
        $member->delete();

        if ($photoPath) {
            Storage::disk('public')->delete($photoPath);
        }

        return redirect()->route('admin.members.index')
            ->with('status', __('members.admin.deleted'));
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'clan';
        $slug = $base;
        $suffix = 2;

        while (AcademyMember::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
