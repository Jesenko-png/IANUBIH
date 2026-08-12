@extends('layouts.app')

@section('title', __('news.meta.title'))
@section('description', __('news.meta.description'))

@section('content')
<section class="inner-hero news-archive-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('news.hero.eyebrow') }}</span>
                <h1 id="page-title">{{ __('news.hero.title') }}</h1>
                <p>{{ __('news.hero.text') }}</p>
                <nav class="breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('news.hero.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page">{{ __('news.hero.current') }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="ianubih-section news-archive" aria-labelledby="news-list-title">
    <div class="container">
        <div class="news-archive-heading">
            <div>
                <span class="section-eyebrow">{{ __('news.list.eyebrow') }}</span>
                <h2 id="news-list-title">{{ __('news.list.title') }}</h2>
            </div>
            <p>{{ __('news.list.intro') }}</p>
        </div>

        @if ($newsPosts->isEmpty())
            <div class="news-empty-state">
                <span aria-hidden="true">01</span>
                <h3>{{ __('news.empty.title') }}</h3>
                <p>{{ __('news.empty.text') }}</p>
            </div>
        @else
            <div class="news-archive-grid">
                @foreach ($newsPosts as $post)
                    <article class="news-archive-card wow fadeInUp" data-wow-delay="{{ ($loop->index % 3) * 0.1 }}s">
                        <a class="news-archive-image" href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}">
                            <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->localized('image_alt') ?: $post->localized('title') }}" loading="lazy">
                            <span>{{ $post->localized('category') }}</span>
                        </a>
                        <div class="news-archive-card-body">
                            <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y.') }}</time>
                            <h3><a href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}">{{ $post->localized('title') }}</a></h3>
                            <p>{{ $post->localized('excerpt') }}</p>
                            <a class="text-link" href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}">
                                {{ __('news.list.read_more') }} <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($newsPosts->hasPages())
                <nav class="news-pagination" aria-label="{{ __('news.pagination.label') }}">
                    @if ($newsPosts->onFirstPage())
                        <span class="disabled">{{ __('news.pagination.previous') }}</span>
                    @else
                        <a href="{{ $newsPosts->previousPageUrl() }}">{{ __('news.pagination.previous') }}</a>
                    @endif
                    <strong>{{ $newsPosts->currentPage() }} / {{ $newsPosts->lastPage() }}</strong>
                    @if ($newsPosts->hasMorePages())
                        <a href="{{ $newsPosts->nextPageUrl() }}">{{ __('news.pagination.next') }}</a>
                    @else
                        <span class="disabled">{{ __('news.pagination.next') }}</span>
                    @endif
                </nav>
            @endif
        @endif
    </div>
</section>

<section class="ianubih-section news-contact-cta" aria-labelledby="news-contact-title">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <span class="section-eyebrow section-eyebrow-light">{{ __('news.cta.eyebrow') }}</span>
                <h2 id="news-contact-title">{{ __('news.cta.title') }}</h2>
                <p>{{ __('news.cta.text') }}</p>
            </div>
            <div class="col-md-4 news-contact-actions">
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="btn btn-ianubih-gold">{{ __('news.cta.button') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
