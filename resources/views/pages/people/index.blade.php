@extends('layouts.app')

@section('title', __('members.public.meta_title'))
@section('description', __('members.public.meta_description'))

@section('content')
<section class="inner-hero people-directory-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row"><div class="col-md-9">
            <span class="section-eyebrow section-eyebrow-light">{{ __('members.public.eyebrow') }}</span>
            <h1 id="page-title">{{ __('members.public.title') }}</h1>
            <p>{{ __('members.public.intro') }}</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('members.public.home') }}</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">{{ __('members.public.title') }}</span>
            </nav>
        </div></div>
    </div>
</section>

<section class="ianubih-section people-directory-section" aria-labelledby="directory-title">
    <div class="container">
        <div class="people-directory-header">
            <div>
                <span class="section-eyebrow">{{ __('members.public.eyebrow') }}</span>
                <h2 id="directory-title">{{ __('members.public.title') }}</h2>
            </div>
            <form class="people-directory-search" method="GET" action="{{ route('people', ['locale' => app()->getLocale()]) }}" role="search">
                <label for="member-query">{{ __('members.public.search_label') }}</label>
                <div>
                    <input id="member-query" type="search" name="q" value="{{ $search }}" maxlength="100" placeholder="{{ __('members.public.search_placeholder') }}">
                    <button type="submit" class="btn btn-ianubih-primary">{{ __('members.public.search_button') }}</button>
                </div>
            </form>
        </div>

        @if ($search !== '' && $storageReady)
            <div class="people-results-line">
                <span>{{ __('members.public.results', ['count' => $members->total()]) }}</span>
                <a href="{{ route('people', ['locale' => app()->getLocale()]) }}">{{ __('members.public.clear_search') }}</a>
            </div>
        @endif

        @if ($members->isEmpty())
            <div class="people-empty-state">
                <i class="fa fa-users" aria-hidden="true"></i>
                <h3>{{ $search !== '' && $storageReady ? __('members.public.no_results_title') : __('members.public.empty_title') }}</h3>
                <p>{{ $search !== '' && $storageReady ? __('members.public.no_results_text') : __('members.public.empty_text') }}</p>
            </div>
        @else
            <div class="people-directory-grid">
                @foreach ($members as $member)
                    <article class="people-member-card">
                        <a class="people-member-image" href="{{ route('people.show', ['locale' => app()->getLocale(), 'slug' => $member->slug]) }}" aria-label="{{ __('members.public.view_profile') }}: {{ $member->name }}">
                            @if ($member->photo_path)
                                <img src="{{ Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}" loading="lazy">
                            @else
                                <span aria-hidden="true"><i class="fa fa-user"></i></span>
                            @endif
                        </a>
                        <div class="people-member-copy">
                            @if ($member->localized('category'))
                                <span class="content-tag">{{ $member->localized('category') }}</span>
                            @endif
                            <h3>{{ trim($member->academic_title.' '.$member->name) }}</h3>
                            @if ($member->localized('position'))
                                <p class="people-member-position">{{ $member->localized('position') }}</p>
                            @endif
                            <p class="people-member-field"><strong>{{ __('members.public.field') }}:</strong> {{ $member->localized('field') }}</p>
                            @if ($member->localized('institution') || $member->localized('country'))
                                <p class="people-member-location">{{ collect([$member->localized('institution'), $member->localized('country')])->filter()->join(' · ') }}</p>
                            @endif
                            @if ($member->localized('bio'))
                                <p class="people-member-summary">{{ \Illuminate\Support\Str::limit($member->localized('bio'), 170) }}</p>
                            @endif
                            <a class="text-link" href="{{ route('people.show', ['locale' => app()->getLocale(), 'slug' => $member->slug]) }}">{{ __('members.public.view_profile') }} <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($members->hasPages())
                <nav class="people-pagination" aria-label="{{ __('members.public.title') }}">
                    @if ($members->onFirstPage())
                        <span>{{ __('members.public.previous') }}</span>
                    @else
                        <a href="{{ $members->previousPageUrl() }}">{{ __('members.public.previous') }}</a>
                    @endif
                    <strong>{{ $members->currentPage() }} / {{ $members->lastPage() }}</strong>
                    @if ($members->hasMorePages())
                        <a href="{{ $members->nextPageUrl() }}">{{ __('members.public.next') }}</a>
                    @else
                        <span>{{ __('members.public.next') }}</span>
                    @endif
                </nav>
            @endif
        @endif
    </div>
</section>
@endsection
