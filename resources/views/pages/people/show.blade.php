@extends('layouts.app')

@section('title', trim($member->academic_title.' '.$member->name).' | IANUBIH')
@section('description', \Illuminate\Support\Str::limit($member->localized('bio') ?: $member->localized('field'), 155))

@section('content')
<section class="inner-hero member-profile-hero" aria-labelledby="page-title">
    <div class="inner-hero-shade"></div>
    <div class="container inner-hero-content">
        <div class="row"><div class="col-md-9">
            <span class="section-eyebrow section-eyebrow-light">{{ $member->localized('category') ?: __('members.public.eyebrow') }}</span>
            <h1 id="page-title">{{ trim($member->academic_title.' '.$member->name) }}</h1>
            <p>{{ $member->localized('position') ?: $member->localized('field') }}</p>
            <nav class="breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('members.public.home') }}</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('people', ['locale' => app()->getLocale()]) }}">{{ __('members.public.title') }}</a>
                <span aria-hidden="true">/</span>
                <span aria-current="page">{{ $member->name }}</span>
            </nav>
        </div></div>
    </div>
</section>

<section class="ianubih-section member-profile-section">
    <div class="container">
        <a href="{{ route('people', ['locale' => app()->getLocale()]) }}" class="text-link member-profile-back">← {{ __('members.public.back_to_members') }}</a>
        <div class="member-profile-layout">
            <aside class="member-profile-aside">
                <div class="member-profile-image">
                    @if ($member->photo_path)
                        <img src="{{ Storage::disk('public')->url($member->photo_path) }}" alt="{{ $member->name }}">
                    @else
                        <span aria-hidden="true"><i class="fa fa-user"></i></span>
                    @endif
                </div>
                @if ($member->email || $member->website_url)
                    <div class="member-profile-contact">
                        <h2>{{ __('members.public.contact') }}</h2>
                        @if ($member->email)
                            <a href="mailto:{{ $member->email }}">{{ __('members.public.email') }}: {{ $member->email }}</a>
                        @endif
                        @if ($member->website_url)
                            <a href="{{ $member->website_url }}" target="_blank" rel="noopener noreferrer">{{ __('members.public.website') }} ↗</a>
                        @endif
                    </div>
                @endif
            </aside>
            <div class="member-profile-main">
                @if ($member->localized('category'))
                    <span class="content-tag">{{ $member->localized('category') }}</span>
                @endif
                <h2>{{ trim($member->academic_title.' '.$member->name) }}</h2>
                @if ($member->localized('position'))
                    <p class="member-profile-position">{{ $member->localized('position') }}</p>
                @endif
                <dl class="member-profile-facts">
                    <div><dt>{{ __('members.public.field') }}</dt><dd>{{ $member->localized('field') }}</dd></div>
                    @if ($member->localized('institution'))
                        <div><dt>{{ __('members.public.institution') }}</dt><dd>{{ $member->localized('institution') }}</dd></div>
                    @endif
                    @if ($member->localized('country'))
                        <div><dt>{{ __('members.public.country') }}</dt><dd>{{ $member->localized('country') }}</dd></div>
                    @endif
                </dl>
                @if ($member->localized('bio'))
                    <div class="member-profile-biography">
                        <h3>{{ __('members.public.about_member') }}</h3>
                        <p>{{ $member->localized('bio') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
