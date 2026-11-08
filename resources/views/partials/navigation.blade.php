@php
    $currentRouteName = request()->route()?->getName() ?? 'home';
    $currentRouteParameters = request()->route()?->parameters() ?? [];
@endphp

<nav class="navbar navbar-fixed-top custom-navbar" role="navigation" aria-label="{{ __('navigation.main') }}">
    <div class="container navbar-main">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false" aria-label="{{ __('navigation.main') }}">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>

            <span class="navbar-institution-name hidden-xs hidden-sm hidden-md">
                {{ __('home.topbar.institution') }}
            </span>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="navbar-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" class="navbar-brand-logo" alt="IASABIH logo">
                <span>IASABIH</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="nav navbar-nav navbar-right academy-nav">
                @foreach (config('academy_navigation') as $menuItem)
                    @include('partials.navigation-item', ['item' => $menuItem, 'depth' => 0])
                @endforeach
                <li class="navbar-utility navbar-search hidden-xs hidden-sm">
                    <a href="{{ route('people', ['locale' => app()->getLocale()]) }}" aria-label="{{ __('navigation.search') }}">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <span class="academy-search-label">{{ __('navigation.search') }}</span>
                    </a>
                </li>
                <li class="navbar-utility navbar-language hidden-xs hidden-sm">
                    <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => 'bs'])) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BOS</a>
                </li>
                <li class="navbar-utility navbar-language hidden-xs hidden-sm">
                    <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => 'en'])) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">ENG</a>
                </li>
                <li class="navbar-login">
                    @auth
                        @if (auth()->user()->canManageNews())
                            <a href="{{ route('admin.news.index') }}" class="nav-login-link" aria-label="{{ __('navigation.administration') }}">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                <span class="nav-login-label">{{ __('navigation.administration') }}</span>
                            </a>
                        @else
                            <a href="{{ route('account.show') }}" class="nav-login-link" aria-label="{{ __('navigation.account') }}">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                <span class="nav-login-label">{{ __('navigation.account') }}</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="nav-login-link" aria-label="{{ __('navigation.login') }}">
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                            <span class="nav-login-label">{{ __('navigation.login') }}</span>
                        </a>
                    @endauth
                </li>
                <li class="visible-xs visible-sm mobile-language">
                    <a href="{{ route($currentRouteName, array_merge($currentRouteParameters, ['locale' => app()->getLocale() === 'bs' ? 'en' : 'bs'])) }}">
                        {{ app()->getLocale() === 'bs' ? 'ENG' : 'BHS' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
