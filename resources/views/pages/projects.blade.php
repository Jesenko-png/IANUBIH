@extends('layouts.app')

@section('title', __('projects.meta.title'))
@section('description', __('projects.meta.description'))

@section('content')
<section class="inner-hero projects-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('projects.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('projects.hero.title') }}</h1>
                <p>{{ __('projects.hero.text') }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('projects.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('projects.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section projects-intro" aria-labelledby="projects-intro-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('projects.intro.eyebrow') }}</span>
                <h2 id="projects-intro-title">{{ __('projects.intro.title') }}</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('projects.intro.text_first') }}</p>
                <p>{{ __('projects.intro.text_second') }}</p>
                <blockquote class="institutional-quote">{{ __('projects.intro.highlight') }}</blockquote>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section project-formats" aria-labelledby="project-formats-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('projects.formats.eyebrow') }}</span>
            <h2 id="project-formats-title">{{ __('projects.formats.title') }}</h2>
            <p>{{ __('projects.formats.intro') }}</p>
        </div>

        <div class="row project-format-grid">
            @foreach(__('projects.formats.items') as $format)
                <div class="col-md-3 col-sm-6">
                    <article class="project-format-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <span class="project-format-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <i class="fa {{ $format['icon'] }}" aria-hidden="true"></i>
                        <h3>{{ $format['title'] }}</h3>
                        <p>{{ $format['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section project-register" aria-labelledby="project-register-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('projects.register.eyebrow') }}</span>
            <h2 id="project-register-title">{{ __('projects.register.title') }}</h2>
            <p>{{ __('projects.register.intro') }}</p>
        </div>

        <div class="project-register-grid">
            @foreach(__('projects.register.items') as $item)
                <article class="project-record project-record-{{ $item['status_class'] }} wow fadeInUp" data-wow-delay="{{ $loop->index * 0.12 }}s">
                    <div class="project-record-topline">
                        <span class="project-status project-status-{{ $item['status_class'] }}">{{ $item['status'] }}</span>
                        <span class="project-kind">{{ $item['kind'] }}</span>
                    </div>
                    <span class="project-programme">{{ $item['programme'] }}</span>
                    <h3>{{ $item['title'] }}</h3>
                    <p class="project-record-summary">{{ $item['text'] }}</p>

                    <dl class="project-record-meta">
                        @foreach($item['meta'] as $meta)
                            <div>
                                <dt>{{ $meta['label'] }}</dt>
                                <dd>{{ $meta['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </article>
            @endforeach
        </div>

        <div class="project-register-source wow fadeInUp">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            <p>{{ __('projects.register.source_note') }}</p>
            <a href="https://www.facebook.com/IANUBIH" target="_blank" rel="noopener noreferrer">{{ __('projects.register.source_link') }}</a>
        </div>
    </div>
</section>

<section class="ianubih-section project-process" aria-labelledby="project-process-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('projects.process.eyebrow') }}</span>
            <h2 id="project-process-title">{{ __('projects.process.title') }}</h2>
            <p>{{ __('projects.process.intro') }}</p>
        </div>

        <div class="project-process-grid">
            @foreach(__('projects.process.items') as $step)
                <article class="project-process-step wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                    <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section projects-cta" aria-labelledby="projects-cta-title">
    <div class="container">
        <div class="row">
            <div class="col-md-8 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('projects.cta.eyebrow') }}</span>
                <h2 id="projects-cta-title">{{ __('projects.cta.title') }}</h2>
                <p>{{ __('projects.cta.text') }}</p>
            </div>
            <div class="col-md-4 projects-cta-actions wow fadeInUp" data-wow-delay="0.15s">
                <a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-gold">{{ __('projects.cta.primary') }}</a>
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('projects.cta.secondary') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
