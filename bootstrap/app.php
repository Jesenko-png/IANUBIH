<?php

use App\Http\Middleware\ApplySessionLocale;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            ApplySessionLocale::class,
        ]);

        $middleware->alias([
            'admin' => EnsureAdmin::class,
            'locale' => SetLocale::class,
            'super_admin' => EnsureSuperAdmin::class,
        ]);
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
        $middleware->redirectUsersTo(fn (Request $request) => $request->user()?->canManageNews()
            ? route('admin.news.index')
            : route('account.show', ['locale' => app()->getLocale()]));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
