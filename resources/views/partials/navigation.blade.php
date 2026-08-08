@php
    $currentRouteName = request()->route()?->getName() ?? 'home';
    $currentRouteParameters = request()->route()?->parameters() ?? [];
@endphp

<nav class="navbar navbar-fixed-top custom-navbar" role="navigation" aria-label="{{ __('navigation.home') }}">
    <div class="institution-bar hidden-xs">
        <div class="container institution-bar-inner">
            <span>{{ __('home.topbar.institution') }}</span>
            <div class="institution-tools">
                <a href="{{ route('people', ['locale' => app()->getLocale()]) }}">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{ __('navigation.search') }}
                </a>
                <span class="institution-divider" aria-hidden="true"></span>
                <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => 'bs'])) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BHS</a>
                <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => 'en'])) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">ENG</a>
            </div>
        </div>
    </div>

    <div class="container navbar-main">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-label="Menu">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="navbar-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" class="navbar-brand-logo" alt="IANUBIH logo">
                <span>IANUBIH</span>
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li @class(['active' => request()->routeIs('about')])><a href="{{ route('about', ['locale' => app()->getLocale()]) }}">{{ __('navigation.about') }}</a></li>
                <li @class(['active' => request()->routeIs('fields')])><a href="{{ route('fields', ['locale' => app()->getLocale()]) }}">{{ __('navigation.areas') }}</a></li>
                <li @class(['active' => request()->routeIs('projects')])><a href="{{ route('projects', ['locale' => app()->getLocale()]) }}">{{ __('navigation.projects') }}</a></li>
                <li @class(['active' => request()->routeIs('publications')])><a href="{{ route('publications', ['locale' => app()->getLocale()]) }}">{{ __('navigation.publications') }}</a></li>
                <li @class(['active' => request()->routeIs('news')])><a href="{{ route('news', ['locale' => app()->getLocale()]) }}">{{ __('navigation.news') }}</a></li>
                <li @class(['active' => request()->routeIs('cooperation')])><a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}">{{ __('navigation.cooperation') }}</a></li>
                <li @class(['active' => request()->routeIs('contact')])><a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="nav-contact-link">{{ __('navigation.contact') }}</a></li>
                <li class="visible-xs mobile-language">
                    <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => app()->getLocale() === 'bs' ? 'en' : 'bs'])) }}">
                        {{ app()->getLocale() === 'bs' ? 'ENG' : 'BHS' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
