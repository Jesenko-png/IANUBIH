@extends('layouts.app')

@section('title', __('fields.meta.title'))
@section('description', __('fields.meta.description'))

@section('content')
<section class="inner-hero fields-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('fields.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('fields.hero.title') }}</h1>
                <p>{{ __('fields.hero.text') }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('fields.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('fields.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section fields-intro" aria-labelledby="fields-intro-title">
    <div class="container">
        <div class="row">
            <div class="col-md-5 wow fadeInUp">
                <span class="section-eyebrow">{{ __('fields.intro.eyebrow') }}</span>
                <h2 id="fields-intro-title">{{ __('fields.intro.title') }}</h2>
            </div>
            <div class="col-md-6 col-md-offset-1 wow fadeInUp" data-wow-delay="0.15s">
                <p class="lead-copy">{{ __('fields.intro.text_first') }}</p>
                <p>{{ __('fields.intro.text_second') }}</p>
                <blockquote class="institutional-quote">{{ __('fields.intro.highlight') }}</blockquote>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section field-catalogue" aria-labelledby="field-catalogue-title">
    <div class="container">
        <div class="section-heading section-heading-centered wow fadeInUp">
            <span class="section-eyebrow">{{ __('fields.areas.eyebrow') }}</span>
            <h2 id="field-catalogue-title">{{ __('fields.areas.title') }}</h2>
            <p>{{ __('fields.areas.intro') }}</p>
        </div>

        <div class="row field-card-grid">
            @foreach(__('fields.areas.items') as $field)
                <div class="col-md-4 col-sm-6">
                    <article class="field-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
                        <div class="field-card-header">
                            <span class="field-card-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <i class="fa {{ $field['icon'] }}" aria-hidden="true"></i>
                        </div>
                        <h3>{{ $field['title'] }}</h3>
                        <p>{{ $field['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="field-connection" aria-labelledby="field-connection-title">
    <div class="container-fluid">
        <div class="row field-connection-row">
            <div class="col-md-6 field-connection-image-wrap wow fadeInLeft">
                <img src="{{ asset('assets/new-event/images/m-web.jpg') }}" alt="{{ __('fields.connection.image_alt') }}" class="field-connection-image">
            </div>
            <div class="col-md-6 field-connection-content wow fadeInRight">
                <span class="section-eyebrow section-eyebrow-light">{{ __('fields.connection.eyebrow') }}</span>
                <h2 id="field-connection-title">{{ __('fields.connection.title') }}</h2>
                <p>{{ __('fields.connection.text_first') }}</p>
                <p>{{ __('fields.connection.text_second') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section field-methods" aria-labelledby="field-methods-title">
    <div class="container">
        <div class="section-heading wow fadeInUp">
            <span class="section-eyebrow">{{ __('fields.methods.eyebrow') }}</span>
            <h2 id="field-methods-title">{{ __('fields.methods.title') }}</h2>
        </div>

        <div class="row method-grid">
            @foreach(__('fields.methods.items') as $method)
                <div class="col-md-3 col-sm-6">
                    <article class="method-card wow fadeInUp" data-wow-delay="{{ $loop->index * 0.1 }}s">
                        <span>{{ $method['number'] }}</span>
                        <h3>{{ $method['title'] }}</h3>
                        <p>{{ $method['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="ianubih-section fields-cta" aria-labelledby="fields-cta-title">
    <div class="container">
        <div class="row">
            <div class="col-md-8 wow fadeInUp">
                <span class="section-eyebrow section-eyebrow-light">{{ __('fields.cta.eyebrow') }}</span>
                <h2 id="fields-cta-title">{{ __('fields.cta.title') }}</h2>
                <p>{{ __('fields.cta.text') }}</p>
            </div>
            <div class="col-md-4 fields-cta-actions wow fadeInUp" data-wow-delay="0.15s">
                <a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-gold">{{ __('fields.cta.primary') }}</a>
                <a href="{{ route('projects', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-light-outline">{{ __('fields.cta.secondary') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
