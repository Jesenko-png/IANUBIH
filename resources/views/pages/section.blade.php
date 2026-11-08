@extends('layouts.app')

@section('title', $title.' | IASABIH')
@section('description', $title.' | IASABIH')

@section('content')
@php
    $overviewRoutes = [
        'academy' => 'about',
        'members' => 'people',
        'organization' => 'organization',
        'publications' => 'publications',
        'cooperation' => 'cooperation',
        'awards' => 'awards',
    ];
    $overviewRoute = $overviewRoutes[$section];
    $isOverview = $topic === 'overview' && $item === null;
    $isOrganizationOverview = $section === 'organization' && $isOverview;
    $childPages = config('academy_pages.'.$section.'.'.$topic, []);
@endphp

<section @class(['inner-hero', 'academy-section-hero', 'has-video' => $isOrganizationOverview]) aria-labelledby="page-title">
    @if ($isOrganizationOverview)
        @include('partials.hero-video', ['file' => 'organizacija-web.mp4', 'poster' => 'f-web.jpg'])
    @endif
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row">
            <div class="col-md-9">
                <span class="section-eyebrow section-eyebrow-light">{{ __('sections.groups.'.$section) }}</span>
                <h1 id="page-title">{{ $title }}</h1>
                <nav class="breadcrumbs" aria-label="{{ __('sections.breadcrumb') }}">
                    <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('navigation.home') }}</a>
                    <span aria-hidden="true">/</span>
                    @unless ($isOverview)
                        <a href="{{ route($overviewRoute, ['locale' => app()->getLocale()]) }}">{{ __('sections.groups.'.$section) }}</a>
                        <span aria-hidden="true">/</span>
                    @endunless
                    <span aria-current="page">{{ $title }}</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="iasabih-section academy-section-body">
    <div class="container">
        @if ($isOrganizationOverview)
            <div class="academy-section-grid">
                @foreach (config('academy_pages.organization') as $sectionTopic => $children)
                    @continue($sectionTopic === 'overview')
                    <a class="academy-section-card" href="{{ route('organization.topic', ['locale' => app()->getLocale(), 'topic' => $sectionTopic]) }}">
                        <span>{{ str_pad($loop->iteration - 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2>{{ __('sections.pages.organization.'.$sectionTopic.'.title') }}</h2>
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                @endforeach
            </div>
        @elseif ($section === 'organization' && $item === null && is_array($childPages))
            <div class="academy-section-grid">
                @foreach ($childPages as $childSlug => $enabled)
                    <a class="academy-section-card" href="{{ route('organization.topic', ['locale' => app()->getLocale(), 'topic' => $topic, 'item' => $childSlug]) }}">
                        <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2>{{ __('sections.pages.organization.'.$topic.'.children.'.$childSlug) }}</h2>
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="academy-section-pending">
                <span class="section-eyebrow">{{ __('sections.status') }}</span>
                @unless ($isOverview)
                    <a href="{{ route($overviewRoute, ['locale' => app()->getLocale()]) }}" class="text-link">← {{ __('sections.back') }}</a>
                @endunless
            </div>
        @endif
    </div>
</section>
@endsection
