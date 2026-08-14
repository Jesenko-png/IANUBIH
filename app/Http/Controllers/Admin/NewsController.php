<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsPostRequest;
use App\Models\NewsPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
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

        return view('admin.news.index', compact('newsPosts'));
    }

    public function create(): View
    {
        return view('admin.news.create');
    }

    public function store(NewsPostRequest $request): RedirectResponse
    {
        $data = $this->normalizedData($request);
        $imagePath = $request->file('image')->store('news', 'public');

        try {
            NewsPost::create([
                ...$data,
                'created_by' => $request->user()->id,
                'slug' => $this->uniqueSlug($data['title_bs']),
                'image_path' => $imagePath,
            ]);
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($imagePath);
            throw $exception;
        }

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.saved'));
    }

    public function edit(NewsPost $newsPost): View
    {
        return view('admin.news.edit', compact('newsPost'));
    }

    public function update(NewsPostRequest $request, NewsPost $newsPost): RedirectResponse
    {
        $data = $this->normalizedData($request);
        $oldImagePath = $newsPost->image_path;
        $newImagePath = null;

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('news', 'public');
            $data['image_path'] = $newImagePath;
        }

        try {
            $newsPost->update($data);
        } catch (Throwable $exception) {
            if ($newImagePath !== null) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $exception;
        }

        if ($newImagePath !== null && $oldImagePath !== $newImagePath) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.updated'));
    }

    public function destroy(NewsPost $newsPost): RedirectResponse
    {
        $imagePath = $newsPost->image_path;
        $newsPost->delete();
        Storage::disk('public')->delete($imagePath);

        return redirect()
            ->route('admin.news.index')
            ->with('status', __('admin.news.deleted'));
    }

    private function normalizedData(NewsPostRequest $request): array
    {
        $data = Arr::except($request->validated(), ['image']);

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
}
