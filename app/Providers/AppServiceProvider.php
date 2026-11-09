<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('pages.about', function ($view) {
            $view->with('about', app(\App\Services\AcademyContent::class)->content('about', app()->getLocale()));
        });
    }
}
