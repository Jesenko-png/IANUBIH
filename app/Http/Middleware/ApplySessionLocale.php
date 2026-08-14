<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySessionLocale
{
    private const SUPPORTED_LOCALES = ['bs', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $requestedLocale = $request->query('locale');

        if (is_string($requestedLocale) && in_array($requestedLocale, self::SUPPORTED_LOCALES, true)) {
            $request->session()->put('locale', $requestedLocale);
        }

        $locale = $request->session()->get('locale', 'bs');

        if (! in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = 'bs';
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
