@extends('layouts.app')

@section('title', __('publications.meta.title'))
@section('description', __('publications.meta.description'))

@section('content')
<section class="inner-hero publications-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('publications.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('publications.hero.title') }}</h1>
                <p>{{ __('publications.hero.text') }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('publications.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('publications.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section publications-intro" aria-labelledby="publications-intro-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('publications.intro.eyebrow') }}</span>
                <h2 id="publications-intro-title">{{ __('publications.intro.title') }}</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('publications.intro.text_first') }}</p>
                <p>{{ __('publications.intro.text_second') }}</p>
                <blockquote class="institutional-quote">{{ __('publications.intro.highlight') }}</blockquote>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section journal-feature" aria-labelledby="journal-title">
    <div class="container">
        <div class="journal-feature-grid">
            <div class="journal-cover wow fadeInUp" aria-hidden="true">
                <div class="journal-cover-top">
                    <span>IANUBIH</span>
                    <span>SAR</span>
                </div>
                <div class="journal-cover-title">
                    <span>Science</span>
                    <span>Art</span>
                    <span>Religion</span>
                </div>
                <div class="journal-cover-mark">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <small>ISSN 3048-4804</small>
            </div>

            <div class="journal-feature-copy wow fadeInUp" data-wow-delay="0.15s">
                <span class="section-eyebrow section-eyebrow-light">{{ __('publications.journal.eyebrow') }}</span>
                <h2 id="journal-title">{{ __('publications.journal.title') }}</h2>
                <p class="journal-lead">{{ __('publications.journal.text') }}</p>

                <ul class="journal-facts" aria-label="{{ __('publications.journal.facts_label') }}">
                    @foreach(__('publications.journal.facts') as $fact)
                        <li><i class="fa fa-check" aria-hidden="true"></i>{{ $fact }}</li>
                    @endforeach
                </ul>

                <dl class="journal-meta">
                    @foreach(__('publications.journal.meta') as $item)
                        <div>
                            <dt>{{ $item['label'] }}</dt>
                            <dd>{{ $item['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div class="journal-actions">
                    <a href="https://www.sarjournal.org/" class="btn btn-ianubih-gold" target="_blank" rel="noopener noreferrer">{{ __('publications.journal.primary') }}</a>
                    <a href="https://ianubih.ba/category/aktivnosti-2022/" class="btn btn-ianubih-light-outline" target="_blank" rel="noopener noreferrer">{{ __('publications.journal.secondary') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section issue-section" aria-labelledby="issues-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('publications.issues.eyebrow') }}</span>
            <h2 id="issues-title">{{ __('publications.issues.title') }}</h2>
            <p>{{ __('publications.issues.intro') }}</p>
        </div>

        <div class="publication-record-grid">
            @foreach(__('publications.issues.items') as $issue)
                <article class="publication-record wow fadeInUp" data-wow-delay="{{ $loop->index * 0.12 }}s">
                    <div class="publication-record-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="publication-record-content">
                        <span class="publication-record-type">{{ $issue['type'] }}</span>
                        <h3>{{ $issue['title'] }}</h3>
                        <p>{{ $issue['text'] }}</p>
                        <div class="publication-record-bottom">
                            <span>{{ $issue['date'] }}</span>
                            <a href="{{ $issue['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $issue['link_aria'] }}">
                                {{ $issue['link'] }} <i class="fa fa-external-link" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section publication-library" aria-labelledby="library-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('publications.library.eyebrow') }}</span>
                <h2 id="library-title">{{ __('publications.library.title') }}</h2>
                <p>{{ __('publications.library.intro') }}</p>
                <div class="publication-library-note">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <p>{{ __('publications.library.note') }}</p>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="publication-library-list">
                    @foreach(__('publications.library.items') as $item)
                        <article class="library-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.12 }}s">
                            <div class="library-item-icon"><i class="fa {{ $item['icon'] }}" aria-hidden="true"></i></div>
                            <div class="library-item-copy">
                                <span>{{ $item['type'] }}</span>
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['text'] }}</p>
                                <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer">
                                    {{ $item['link'] }} <i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section publication-formats" aria-labelledby="publication-formats-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('publications.formats.eyebrow') }}</span>
            <h2 id="publication-formats-title">{{ __('publications.formats.title') }}</h2>
            <p>{{ __('publications.formats.intro') }}</p>
        </div>

        <div class="publication-format-grid">
            @foreach(__('publications.formats.items') as $format)
                <article class="publication-format-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <i class="fa {{ $format['icon'] }}" aria-hidden="true"></i>
                    <h3>{{ $format['title'] }}</h3>
                    <p>{{ $format['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section publications-cta" aria-labelledby="publications-cta-title">
    <div class="container">
        <div class="row">
            <div class="col-md-8 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('publications.cta.eyebrow') }}</span>
                <h2 id="publications-cta-title">{{ __('publications.cta.title') }}</h2>
                <p>{{ __('publications.cta.text') }}</p>
            </div>
            <div class="col-md-4 publications-cta-actions wow fadeInUp" data-wow-delay="0.15s">
                <a href="https://www.sarjournal.org/" class="btn btn-ianubih-gold" target="_blank" rel="noopener noreferrer">{{ __('publications.cta.primary') }}</a>
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('publications.cta.secondary') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
