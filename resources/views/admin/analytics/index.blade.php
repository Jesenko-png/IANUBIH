@extends('layouts.admin')

@section('title', __('admin.analytics.title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('admin.analytics.eyebrow') }}</span>
        <h1>{{ __('admin.analytics.title') }}</h1>
        <p>{{ __('admin.analytics.intro') }}</p>
    </div>
    <a href="https://analytics.google.com/analytics/web/" target="_blank" rel="noopener noreferrer" class="admin-button admin-button-primary">
        {{ __('admin.analytics.open_google') }}
    </a>
</div>

<section class="admin-panel analytics-overview" aria-labelledby="analytics-status-title">
    <div class="analytics-status-card">
        <span class="analytics-status-dot" aria-hidden="true"></span>
        <div>
            <span class="admin-eyebrow">{{ __('admin.analytics.status_label') }}</span>
            <h2 id="analytics-status-title">{{ __('admin.analytics.status_active') }}</h2>
            <p>{{ __('admin.analytics.status_text') }}</p>
        </div>
        <code>G-2KJZQ71XQX</code>
    </div>

    <div class="analytics-information-grid">
        <article>
            <span>01</span>
            <h3>{{ __('admin.analytics.consent_title') }}</h3>
            <p>{{ __('admin.analytics.consent_text') }}</p>
        </article>
        <article>
            <span>02</span>
            <h3>{{ __('admin.analytics.reports_title') }}</h3>
            <p>{{ __('admin.analytics.reports_text') }}</p>
        </article>
        <article>
            <span>03</span>
            <h3>{{ __('admin.analytics.api_title') }}</h3>
            <p>{{ __('admin.analytics.api_text') }}</p>
        </article>
    </div>
</section>
@endsection
