<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsPostRequest;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsPosts = NewsPost::query()
            ->with('author')
            ->latest('updated_at')
            ->paginate(15);

        $secondaryImagesReady = $this->secondaryImagesReady();

        return view('admin.news.index', compact('newsPosts', 'secondaryImagesReady'));
    }

    public function setupSecondaryImages(): RedirectResponse
    {
        if ($this->secondaryImagesReady()) {
            return redirect()->route('admin.news.index')
                ->with('status', __('admin.news.images_already_ready'));
        }

        try {
            if (Schema::hasTable('migrations')) {
                DB::table('migrations')
                    ->where('migration', '2026_10_08_000000_add_secondary_image_to_news_posts_table')
                    ->delete();
            }

            $exitCode = Artisan::call('migrate', [
                '--force' => true,
                '--path' => 'database/migrations/2026_10_08_000000_add_secondary_image_to_news_posts_table.php',
            ]);

            if ($exitCode !== 0 || ! $this->secondaryImagesReady()) {
                throw new \RuntimeException('The news secondary-image migration did not complete.');
            }
        } catch (Throwable $exception) {
            report($exception);

            return redirect()->route('admin.news.index')
                ->withErrors(['storage' => __('admin.news.images_setup_error')]);
        }

        return redirect()->route('admin.news.index')
            ->with('status', __('admin.news.images_ready'));
    }

    public function create(): View
    {
        $secondaryImagesReady = $this->secondaryImagesReady();

        return view('admin.news.create', compact('secondaryImagesReady'));
    }

    public function store(NewsPostRequest $request): RedirectResponse
    {
        $data = $this->normalizedData($request);
        $imagePath = null;
        $secondaryImagePath = null;

        try {
            $imagePath = $request->file('image')->store('news', 'public');
            $secondaryImagePath = $request->file('secondary_image')?->store('news', 'public');
            NewsPost::create([
                ...$data,
                'created_by' => $request->user()->id,
                'slug' => $this->uniqueSlug($data['title_bs']),
                'image_path' => $imagePath,
                ...($secondaryImagePath ? ['secondary_image_path' => $secondaryImagePath] : []),
            ]);
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            if ($secondaryImagePath) {
                Storage::disk('public')->delete($secondaryImagePath);
            }
            throw $exception;
        }

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.saved'));
    }

    public function edit(NewsPost $newsPost): View
    {
        $secondaryImagesReady = $this->secondaryImagesReady();

        return view('admin.news.edit', compact('newsPost', 'secondaryImagesReady'));
    }

    public function update(NewsPostRequest $request, NewsPost $newsPost): RedirectResponse
    {
        $data = $this->normalizedData($request);
        $oldImagePath = $newsPost->image_path;
        $oldSecondaryImagePath = $newsPost->secondary_image_path;
        $newImagePath = null;
        $newSecondaryImagePath = null;

        try {
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('news', 'public');
                $data['image_path'] = $newImagePath;
            }

            if ($request->hasFile('secondary_image')) {
                $newSecondaryImagePath = $request->file('secondary_image')->store('news', 'public');
                $data['secondary_image_path'] = $newSecondaryImagePath;
            } elseif ($request->boolean('remove_secondary_image')) {
                $data['secondary_image_path'] = null;
                $data['secondary_image_alt_bs'] = null;
                $data['secondary_image_alt_en'] = null;
            }

            $newsPost->update($data);
        } catch (Throwable $exception) {
            if ($newImagePath !== null) {
                Storage::disk('public')->delete($newImagePath);
            }
            if ($newSecondaryImagePath !== null) {
                Storage::disk('public')->delete($newSecondaryImagePath);
            }

            throw $exception;
        }

        if ($newImagePath !== null && $oldImagePath !== $newImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }
        if ($oldSecondaryImagePath && array_key_exists('secondary_image_path', $data)) {
            Storage::disk('public')->delete($oldSecondaryImagePath);
        }

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.updated'));
    }

    public function destroy(NewsPost $newsPost): RedirectResponse
    {
        $imagePath = $newsPost->image_path;
        $secondaryImagePath = $newsPost->secondary_image_path;
        $newsPost->delete();
        Storage::disk('public')->delete($imagePath);
        if ($secondaryImagePath) {
            Storage::disk('public')->delete($secondaryImagePath);
        }

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.deleted'));
    }

    private function normalizedData(NewsPostRequest $request): array
    {
        $data = Arr::except($request->validated(), ['image', 'secondary_image', 'remove_secondary_image']);

        if ($data['status'] === 'published' && blank($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($data['status'] === 'draft') {
            $data['published_at'] = null;
        }

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'vijest-'.now()->format('Ymd-His');
        $slug = $base;
        $suffix = 2;

        while (NewsPost::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    private function secondaryImagesReady(): bool
    {
        return Schema::hasColumn('news_posts', 'secondary_image_path')
            && Schema::hasColumn('news_posts', 'secondary_image_alt_bs')
            && Schema::hasColumn('news_posts', 'secondary_image_alt_en');
    }
}
