<?php

namespace App\Http\Controllers;

use App\Models\NewsPost;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [];

        // Include only public GET routes whose sole parameter is the locale.
        foreach (Route::getRoutes() as $route) {
            if (! $route->getName()
                || ! in_array('GET', $route->methods(), true)
                || $route->parameterNames() !== ['locale']) {
                continue;
            }

            foreach (['bs', 'en'] as $locale) {
                $urls[] = route($route->getName(), ['locale' => $locale]);
            }
        }

        if (Schema::hasTable('news_posts')) {
            foreach (NewsPost::query()->published()->select('slug')->cursor() as $post) {
                foreach (['bs', 'en'] as $locale) {
                    $urls[] = route('news.show', ['locale' => $locale, 'newsPost' => $post->slug]);
                }
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach (array_unique($urls) as $url) {
            $xml .= '<url><loc>'.htmlspecialchars($url, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc></url>';
        }

        return response($xml.'</urlset>', 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
