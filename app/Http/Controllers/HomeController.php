<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(string $locale): View
    {
        $latestNews = NewsPost::query()
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('home', compact('latestNews'));
    }
}
