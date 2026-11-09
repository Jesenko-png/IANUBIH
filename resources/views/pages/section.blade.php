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
    $isPresidency = $section === 'organization' && $topic === 'presidency' && $item === null;
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
        @if ($section === 'academy' && filled($academyContent['body'] ?? null))
            <div class="member-profile-biography" style="white-space: pre-line; overflow-wrap: anywhere">{{ $academyContent['body'] }}</div>
        @elseif ($isOrganizationOverview)
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
        @elseif ($isPresidency)
            @php($president = __('sections.pages.organization.presidency'))
            <div class="member-profile-layout">
                <aside class="member-profile-aside">
                    <div class="member-profile-image">
                        <img src="{{ asset('uploads/news/almir-badnjevic-predsjednik-iasabih.jpeg') }}" alt="{{ $president['image_alt'] }}">
                    </div>
                </aside>
                <div class="member-profile-main">
                    <span class="content-tag">{{ $president['role'] }}</span>
                    <h2>{{ $president['name'] }}</h2>
                    <p class="member-profile-position">{{ $president['position'] }}</p>
                    <dl class="member-profile-facts">
                        <div><dt>{{ __('members.public.field') }}</dt><dd>{{ $president['field'] }}</dd></div>
                        <div><dt>{{ __('members.public.institution') }}</dt><dd>{{ $president['institution'] }}</dd></div>
                        <div><dt>{{ __('members.public.country') }}</dt><dd>{{ $president['country'] }}</dd></div>
                    </dl>
                    <div class="member-profile-biography">
                        <h3>{{ __('members.public.about_member') }}</h3>
                        <p>{{ $president['bio'] }}</p>
                    </div>
                </div>
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
