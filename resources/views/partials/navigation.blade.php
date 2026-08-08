<nav class="navbar navbar-fixed-top custom-navbar" role="navigation" aria-label="{{ __('navigation.home') }}">
    <div class="institution-bar hidden-xs">
        <div class="container institution-bar-inner">
            <span>{{ __('home.topbar.institution') }}</span>
            <div class="institution-tools">
                <a href="#people" class="smoothScroll">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    {{ __('navigation.search') }}
                </a>
                <span class="institution-divider" aria-hidden="true"></span>
                <a href="{{ route('home', ['locale' => 'bs']) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BHS</a>
                <a href="{{ route('home', ['locale' => 'en']) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">ENG</a>
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
                <li><a href="#about" class="smoothScroll">{{ __('navigation.about') }}</a></li>
                <li><a href="#areas" class="smoothScroll">{{ __('navigation.areas') }}</a></li>
                <li><a href="#projects" class="smoothScroll">{{ __('navigation.projects') }}</a></li>
                <li><a href="#publications" class="smoothScroll">{{ __('navigation.publications') }}</a></li>
                <li><a href="#news" class="smoothScroll">{{ __('navigation.news') }}</a></li>
                <li><a href="#cooperation" class="smoothScroll">{{ __('navigation.cooperation') }}</a></li>
                <li><a href="#contact" class="smoothScroll nav-contact-link">{{ __('navigation.contact') }}</a></li>
                <li class="visible-xs mobile-language">
                    <a href="{{ route('home', ['locale' => app()->getLocale() === 'bs' ? 'en' : 'bs']) }}">
                        {{ app()->getLocale() === 'bs' ? 'ENG' : 'BHS' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
