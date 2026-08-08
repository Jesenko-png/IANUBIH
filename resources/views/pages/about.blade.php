@extends('layouts.app')

@section('title', __('about.meta.title'))
@section('description', __('about.meta.description'))

@section('content')
<section class="inner-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('about.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('about.hero.title') }}</h1>
                <p>{{ __('about.hero.text') }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('about.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('about.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section about-identity" aria-labelledby="identity-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('about.identity.eyebrow') }}</span>
                <h2 id="identity-title">{{ __('about.identity.title') }}</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('about.identity.text_first') }}</p>
                <p>{{ __('about.identity.text_second') }}</p>
                <blockquote class="institutional-quote">{{ __('about.identity.highlight') }}</blockquote>
            </div>
        </div>
    </div>
</section>

<section id="mission" class="ianubih-section mission-section" aria-labelledby="mission-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('about.mission.eyebrow') }}</span>
            <h2 id="mission-title">{{ __('about.mission.title') }}</h2>
        </div>
        <div class="row mission-grid">
            <div class="col-md-6">
                <article class="mission-card wow fadeInUp">
                    <span class="mission-number">01</span>
                    <h3>{{ __('about.mission.mission_title') }}</h3>
                    <p>{{ __('about.mission.mission_text') }}</p>
                </article>
            </div>
            <div class="col-md-6">
                <article class="mission-card mission-card-blue wow fadeInUp" data-wow-delay="0.12s">
                    <span class="mission-number">02</span>
                    <h3>{{ __('about.mission.vision_title') }}</h3>
                    <p>{{ __('about.mission.vision_text') }}</p>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section values-section" aria-labelledby="values-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('about.values.eyebrow') }}</span>
            <h2 id="values-title">{{ __('about.values.title') }}</h2>
        </div>
        <div class="row values-grid">
            @foreach(__('about.values.items') as $value)
                <div class="col-md-4 col-sm-6">
                    <article class="value-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
                        <i class="fa {{ $value['icon'] }}" aria-hidden="true"></i>
                        <h3>{{ $value['title'] }}</h3>
                        <p>{{ $value['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section president-section" aria-labelledby="president-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInLeft">
                <div class="president-mark" aria-hidden="true">“</div>
                <span class="verification-badge">{{ __('about.president.status') }}</span>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInRight">
                <span class="section-eyebrow section-eyebrow-light">{{ __('about.president.eyebrow') }}</span>
                <h2 id="president-title">{{ __('about.president.title') }}</h2>
                <p>{{ __('about.president.text') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section governance-section" aria-labelledby="governance-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('about.governance.eyebrow') }}</span>
            <h2 id="governance-title">{{ __('about.governance.title') }}</h2>
            <p>{{ __('about.governance.text') }}</p>
        </div>
        <div class="row governance-grid">
            @foreach(__('about.governance.items') as $item)
                <div class="col-md-4">
                    <article class="governance-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section documents-section" aria-labelledby="documents-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('about.documents.eyebrow') }}</span>
                <h2 id="documents-title">{{ __('about.documents.title') }}</h2>
                <p>{{ __('about.documents.text') }}</p>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="document-list wow fadeInUp" data-wow-delay="0.15s">
                    @foreach(__('about.documents.items') as $document)
                        <div class="document-item">
                            <i class="fa {{ $document['icon'] }}" aria-hidden="true"></i>
                            <span>{{ $document['title'] }}</span>
                            <small>{{ __('about.documents.status') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section faq-section" aria-labelledby="faq-title">
    <div class="container">
        <div class="row">
            <div class="col-md-4 wow fadeInUp">
                <span class="section-eyebrow">{{ __('about.faq.eyebrow') }}</span>
                <h2 id="faq-title">{{ __('about.faq.title') }}</h2>
            </div>
            <div class="col-md-7 col-md-offset-1 faq-list wow fadeInUp" data-wow-delay="0.15s">
                @foreach(__('about.faq.items') as $item)
                    <details class="faq-item" @if ($loop->first) open @endif>
                        <summary>{{ $item['question'] }} <span aria-hidden="true">+</span></summary>
                        <p>{{ $item['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section about-cta" aria-labelledby="about-cta-title">
    <div class="container">
        <div class="row">
            <div class="col-md-8 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('about.cta.eyebrow') }}</span>
                <h2 id="about-cta-title">{{ __('about.cta.title') }}</h2>
                <p>{{ __('about.cta.text') }}</p>
            </div>
            <div class="col-md-4 about-cta-actions wow fadeInUp" data-wow-delay="0.15s">
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-gold">{{ __('about.cta.primary') }}</a>
                <a href="{{ route('fields', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('about.cta.secondary') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
