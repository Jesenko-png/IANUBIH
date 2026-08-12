<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(string $locale): View
    {
        $newsPosts = NewsPost::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('pages.news.index', compact('newsPosts'));
    }

    public function show(string $locale, NewsPost $newsPost): View
    {
        abort_unless($newsPost->isPublished(), 404);

        $relatedPosts = NewsPost::query()
            ->published()
            ->whereKeyNot($newsPost->getKey())
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.news.show', compact('newsPost', 'relatedPosts'));
    }
}
