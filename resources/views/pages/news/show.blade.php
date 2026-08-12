@extends('layouts.app')

@section('title', $newsPost->localized('title') . ' | IANUBIH')
@section('description', $newsPost->localized('excerpt'))

@section('content')
<article class="news-article">
    <header class="news-article-header">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <nav class="breadcrumbs news-article-breadcrumbs" aria-label="Breadcrumb">
                        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('news.hero.home') }}</a>
                        <span aria-hidden="true">/</span>
                        <a href="{{ route('news', ['locale' => app()->getLocale()]) }}">{{ __('news.hero.current') }}</a>
                    </nav>
                    <span class="section-eyebrow section-eyebrow-light">{{ $newsPost->localized('category') }}</span>
                    <h1>{{ $newsPost->localized('title') }}</h1>
                    <p class="news-article-lead">{{ $newsPost->localized('excerpt') }}</p>
                    <time datetime="{{ $newsPost->published_at->toDateString() }}">{{ __('news.article.published') }} {{ $newsPost->published_at->format('d.m.Y.') }}</time>
                </div>
            </div>
        </div>
    </header>

    <div class="container news-article-container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <figure class="news-article-cover">
                    <img src="{{ Storage::url($newsPost->image_path) }}" alt="{{ $newsPost->localized('image_alt') ?: $newsPost->localized('title') }}">
                </figure>
                <div class="news-article-layout">
                    <aside class="news-article-aside">
                        <span>{{ __('news.article.category') }}</span>
                        <strong>{{ $newsPost->localized('category') }}</strong>
                        <a href="{{ route('news', ['locale' => app()->getLocale()]) }}">← {{ __('news.article.back') }}</a>
                    </aside>
                    <div class="news-article-body">
                        {!! nl2br(e($newsPost->localized('body'))) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

@if ($relatedPosts->isNotEmpty())
<section class="ianubih-section related-news" aria-labelledby="related-news-title">
    <div class="container">
        <div class="section-heading">
            <span class="section-eyebrow">{{ __('news.related.eyebrow') }}</span>
            <h2 id="related-news-title">{{ __('news.related.title') }}</h2>
        </div>
        <div class="news-archive-grid">
            @foreach ($relatedPosts as $post)
                <article class="news-archive-card">
                    <a class="news-archive-image" href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}">
                        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->localized('image_alt') ?: $post->localized('title') }}" loading="lazy">
                        <span>{{ $post->localized('category') }}</span>
                    </a>
                    <div class="news-archive-card-body">
                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('d.m.Y.') }}</time>
                        <h3><a href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}">{{ $post->localized('title') }}</a></h3>
                        <p>{{ $post->localized('excerpt') }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
