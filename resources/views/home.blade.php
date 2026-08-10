@extends('layouts.app')

@section('title', __('home.meta.title'))
@section('description', __('home.meta.description'))

@section('content')
<section id="intro" class="ianubih-hero parallax-section" aria-labelledby="hero-title">
    <div class="hero-shade"></div>
    <div class="container hero-container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="hero-content">
                    <img src="{{ asset('assets/new-event/images/logo.jpg') }}" class="hero-logo wow fadeInDown" alt="IANUBIH logo">
                    <p class="hero-eyebrow wow fadeInUp" data-wow-delay="0.2s">{{ __('home.hero.eyebrow') }}</p>
                    <h1 id="hero-title" class="wow fadeInUp" data-wow-delay="0.35s">
                        <span>{{ __('home.hero.title_first') }}</span>
                        <span>{{ __('home.hero.title_second') }}</span>
                    </h1>
                    <p class="hero-lead wow fadeInUp" data-wow-delay="0.5s">{{ __('home.hero.text') }}</p>
                    <div class="hero-actions wow fadeInUp" data-wow-delay="0.65s">
                        <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('home.hero.primary') }}</a>
                        <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-outline">{{ __('home.hero.secondary') }}</a>
                    </div>
                    <a href="{{ route('people', ['locale' => app()->getLocale()]) }}" class="hero-quick-link wow fadeInUp" data-wow-delay="0.8s">
                        {{ __('home.hero.expert') }} <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="ianubih-section statement-section" aria-labelledby="statement-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('home.statement.eyebrow') }}</span>
                <h2 id="statement-title">{{ __('home.statement.title') }}</h2>
                <div class="gold-rule"></div>
            </div>
            <div class="col-md-6 col-md-offset-1 statement-copy wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('home.statement.text_first') }}</p>
                <p>{{ __('home.statement.text_second') }}</p>
                <a href="{{ route('about', ['locale' => app()->getLocale()]) }}#mission" class="text-link">{{ __('home.statement.link') }} <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>
</section>

<section id="areas" class="ianubih-section pillars-section" aria-labelledby="pillars-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('home.pillars.eyebrow') }}</span>
            <h2 id="pillars-title">{{ __('home.pillars.title') }}</h2>
            <p>{{ __('home.pillars.intro') }}</p>
        </div>

        @php($pillarTargets = [
            route('fields', ['locale' => app()->getLocale()]),
            route('cooperation', ['locale' => app()->getLocale()]),
            route('people', ['locale' => app()->getLocale()]),
            route('projects', ['locale' => app()->getLocale()]),
        ])
        <div class="row pillar-grid">
            @foreach(__('home.pillars.items') as $pillar)
                <div class="col-md-3 col-sm-6">
                    <article class="pillar-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <div class="pillar-icon"><i class="fa {{ $pillar['icon'] }}" aria-hidden="true"></i></div>
                        <h3>{{ $pillar['title'] }}</h3>
                        <p>{{ $pillar['text'] }}</p>
                        <a href="{{ $pillarTargets[$loop->index] }}" class="text-link">{{ $pillar['link'] }} <span aria-hidden="true">→</span></a>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="projects" class="ianubih-section initiative-section" aria-labelledby="initiative-title">
    <div class="container-fluid">
        <div class="row initiative-row">
            <div class="col-md-6 initiative-image-wrap wow fadeInLeft">
                <img src="{{ asset('assets/new-event/images/b-web.jpg') }}" alt="{{ __('home.initiative.image_alt') }}" class="initiative-image">
            </div>
            <div class="col-md-6 initiative-content wow fadeInRight">
                <span class="section-eyebrow section-eyebrow-light">{{ __('home.initiative.eyebrow') }}</span>
                <h2 id="initiative-title">{{ __('home.initiative.title') }}</h2>
                <p>{{ __('home.initiative.text') }}</p>
                <div class="section-actions">
                    <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-gold">{{ __('home.initiative.primary') }}</a>
                    <a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('home.initiative.secondary') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="disciplines" class="ianubih-section disciplines-section" aria-labelledby="disciplines-title">
    <div class="container">
        <div class="row disciplines-heading-row">
            <div class="col-md-8 wow fadeInUp">
                <span class="section-eyebrow">{{ __('home.disciplines.eyebrow') }}</span>
                <h2 id="disciplines-title">{{ __('home.disciplines.title') }}</h2>
                <p>{{ __('home.disciplines.text') }}</p>
            </div>
            <div class="col-md-3 col-md-offset-1 disciplines-heading-action wow fadeInUp" data-wow-delay="0.1s">
                <a href="{{ route('fields', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('home.disciplines.cta') }}</a>
            </div>
        </div>

        @php($disciplineIcons = ['fa-users', 'fa-heartbeat', 'fa-book', 'fa-cogs', 'fa-paint-brush', 'fa-comments-o', 'fa-graduation-cap', 'fa-globe', 'fa-leaf'])
        @php($disciplineImages = ['social-sciences.jpg', 'medical-sciences.jpg', 'humanities-culture.jpg', 'technical-sciences.jpg', 'arts.jpg', 'intercultural-dialogue.jpg', 'young-scientists.jpg', 'scientific-diaspora.jpg', 'sustainable-development.jpg'])

        <div class="discipline-map" role="list">
            @foreach(__('home.disciplines.items') as $discipline)
                <article
                    class="discipline-tile wow fadeInUp"
                    data-number="{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}"
                    data-wow-delay="{{ ($loop->index % 3) * 0.08 }}s"
                    role="listitem"
                >
                    <span
                        class="discipline-tile-image"
                        style="background-image: url('{{ asset('assets/new-event/images/disciplines/' . $disciplineImages[$loop->index]) }}')"
                        aria-hidden="true"
                    ></span>
                    <div class="discipline-tile-meta">
                        <span class="discipline-number" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="discipline-icon" aria-hidden="true">
                            <i class="fa {{ $disciplineIcons[$loop->index] }}"></i>
                        </span>
                    </div>
                    <h3>{{ $discipline }}</h3>
                    <span class="discipline-tile-line" aria-hidden="true"></span>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="publications" class="ianubih-section publications-section" aria-labelledby="publications-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('home.publications.eyebrow') }}</span>
            <h2 id="publications-title">{{ __('home.publications.title') }}</h2>
            <p>{{ __('home.publications.text') }}</p>
        </div>

        <div class="row publication-grid">
            @foreach(__('home.publications.items') as $publication)
                <div class="col-md-4 col-sm-6">
                    <article class="publication-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.12 }}s">
                        <div class="publication-icon"><i class="fa {{ $publication['icon'] }}" aria-hidden="true"></i></div>
                        <span class="content-tag">{{ $publication['type'] }}</span>
                        <h3>{{ $publication['title'] }}</h3>
                        <p>{{ $publication['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="section-actions section-actions-dark wow fadeInUp">
            <a href="{{ route('publications', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('home.publications.all') }}</a>
            <a href="{{ route('publications', ['locale' => app()->getLocale()]) }}#sar" class="btn btn-ianubih-secondary">{{ __('home.publications.journal') }}</a>
        </div>
    </div>
</section>

<section id="events" class="ianubih-section events-section" aria-labelledby="events-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('home.events.eyebrow') }}</span>
                <h2 id="events-title">{{ __('home.events.title') }}</h2>
                <p>{{ __('home.events.text') }}</p>
                <a href="{{ route('events', ['locale' => app()->getLocale()]) }}" class="text-link">{{ __('home.events.all') }} <span aria-hidden="true">→</span></a>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <article class="event-card">
                    <div class="event-date">
                        <i class="fa fa-calendar-o" aria-hidden="true"></i>
                        <span>{{ __('home.events.status') }}</span>
                    </div>
                    <div class="event-details">
                        <span class="content-tag">{{ __('home.events.organizer') }}</span>
                        <h3>{{ __('home.events.calendar_title') }}</h3>
                        <p>{{ __('home.events.calendar_text') }}</p>
                        <div class="event-meta">
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> {{ __('home.events.location') }}</span>
                            <span><i class="fa fa-building-o" aria-hidden="true"></i> {{ __('home.events.organizer') }}</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section id="people" class="ianubih-section people-section" aria-labelledby="people-title">
    <div class="people-pattern" aria-hidden="true"></div>
    <div class="container people-content">
        <div class="row">
            <div class="col-md-7 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('home.people.eyebrow') }}</span>
                <h2 id="people-title">{{ __('home.people.title') }}</h2>
                <p class="people-lead">{{ __('home.people.text') }}</p>
                <p>{{ __('home.people.search_text') }}</p>
            </div>
            <div class="col-md-5 wow fadeInUp" data-wow-delay="0.15s">
                <form class="expert-search" method="GET" action="{{ route('people', ['locale' => app()->getLocale()]) }}" role="search" aria-label="{{ __('home.people.aria') }}">
                    <label class="sr-only" for="expert-query">{{ __('home.people.placeholder') }}</label>
                    <div class="expert-input-wrap">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input id="expert-query" type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('home.people.placeholder') }}">
                    </div>
                    <button type="submit" class="btn btn-ianubih-gold">{{ __('home.people.button') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="network" class="ianubih-section network-section" aria-labelledby="network-title">
    <div class="container">
        <div class="row network-row">
            <div class="col-md-6 wow fadeInLeft">
                <div class="network-visual" role="img" aria-label="{{ __('home.network.visual_label') }}">
                    <div class="network-globe"><i class="fa fa-globe" aria-hidden="true"></i></div>
                    <span class="network-node node-one"></span>
                    <span class="network-node node-two"></span>
                    <span class="network-node node-three"></span>
                    <span class="network-node node-four"></span>
                    <span class="network-node node-five"></span>
                    <span class="network-line line-one"></span>
                    <span class="network-line line-two"></span>
                    <span class="network-line line-three"></span>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1 wow fadeInRight">
                <span class="section-eyebrow">{{ __('home.network.eyebrow') }}</span>
                <h2 id="network-title">{{ __('home.network.title') }}</h2>
                <p>{{ __('home.network.text') }}</p>
                <a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('home.network.cta') }}</a>
            </div>
        </div>
    </div>
</section>

<section id="cooperation" class="ianubih-section cooperation-section" aria-labelledby="cooperation-title">
    <div class="container">
        <div class="row">
            <div class="col-md-9 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('home.cooperation.eyebrow') }}</span>
                <h2 id="cooperation-title">{{ __('home.cooperation.title') }}</h2>
                <p>{{ __('home.cooperation.text_first') }}</p>
                <p>{{ __('home.cooperation.text_second') }}</p>
            </div>
            <div class="col-md-3 cooperation-actions wow fadeInUp" data-wow-delay="0.15s">
                <a href="mailto:info@ianubih.ba" class="btn btn-ianubih-gold">{{ __('home.cooperation.primary') }}</a>
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('home.cooperation.secondary') }}</a>
            </div>
        </div>
    </div>
</section>

<section id="news" class="ianubih-section news-section" aria-labelledby="news-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('home.news.eyebrow') }}</span>
            <h2 id="news-title">{{ __('home.news.title') }}</h2>
            <p>{{ __('home.news.intro') }}</p>
        </div>

        <div class="row news-grid">
            @foreach(__('home.news.items') as $item)
                <div class="col-md-4">
                    <article class="news-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.12 }}s">
                        <div class="news-image-wrap">
                            <img src="{{ asset('assets/new-event/images/' . $item['image']) }}" alt="">
                        </div>
                        <div class="news-body">
                            <span class="content-tag">{{ $item['category'] }}</span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['text'] }}</p>
                            <a href="{{ route('news', ['locale' => app()->getLocale()]) }}" class="text-link">{{ __('home.news.read_more') }} <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="section-actions section-actions-centered wow fadeInUp">
            <a href="{{ route('news', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-primary">{{ __('home.news.all') }}</a>
        </div>
    </div>
</section>
@endsection
