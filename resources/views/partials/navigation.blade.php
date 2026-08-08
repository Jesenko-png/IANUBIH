<nav class="navbar navbar-fixed-top custom-navbar" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-label="Menu">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="navbar-brand">
                IANUBIH
            </a>
        </div>

        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#intro" class="smoothScroll">{{ __('navigation.home') }}</a></li>
                <li><a href="#overview" class="smoothScroll">{{ __('navigation.about') }}</a></li>
                <li><a href="#speakers" class="smoothScroll">{{ __('navigation.people') }}</a></li>
                <li><a href="#program" class="smoothScroll">{{ __('navigation.areas') }}</a></li>
                <li><a href="#register" class="smoothScroll">{{ __('navigation.cooperation') }}</a></li>
                <li><a href="#sponsors" class="smoothScroll">{{ __('navigation.partners') }}</a></li>
                <li><a href="#contact" class="smoothScroll">{{ __('navigation.contact') }}</a></li>
                <li>
                    <a href="{{ route('home', ['locale' => app()->getLocale() === 'bs' ? 'en' : 'bs']) }}">
                        {{ app()->getLocale() === 'bs' ? 'ENG' : 'BHS' }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
