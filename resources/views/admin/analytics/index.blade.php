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
    </div>

</section>

@if ($dashboard)
    <div class="analytics-dashboard-heading">
        <div>
            <span class="admin-eyebrow">{{ __('admin.analytics.report_period') }}</span>
            <h2>{{ __('admin.analytics.dashboard_title') }}</h2>
        </div>
        <small>{{ __('admin.analytics.last_updated', ['time' => \Carbon\Carbon::parse($dashboard['updated_at'])->format('d.m.Y. H:i')]) }}</small>
    </div>

    <section class="analytics-metrics" aria-label="{{ __('admin.analytics.dashboard_title') }}">
        <article class="admin-panel analytics-metric-card">
            <span>{{ __('admin.analytics.active_users') }}</span>
            <strong>{{ number_format($dashboard['active_users'], 0, ',', app()->getLocale() === 'bs' ? '.' : ',') }}</strong>
        </article>
        <article class="admin-panel analytics-metric-card">
            <span>{{ __('admin.analytics.sessions') }}</span>
            <strong>{{ number_format($dashboard['sessions'], 0, ',', app()->getLocale() === 'bs' ? '.' : ',') }}</strong>
        </article>
        <article class="admin-panel analytics-metric-card">
            <span>{{ __('admin.analytics.page_views') }}</span>
            <strong>{{ number_format($dashboard['page_views'], 0, ',', app()->getLocale() === 'bs' ? '.' : ',') }}</strong>
        </article>
    </section>

    <section class="admin-panel analytics-chart-panel" aria-labelledby="analytics-trend-title">
        <div class="analytics-panel-heading">
            <div>
                <span class="admin-eyebrow">{{ __('admin.analytics.trend_eyebrow') }}</span>
                <h2 id="analytics-trend-title">{{ __('admin.analytics.trend_title') }}</h2>
            </div>
            <p>{{ __('admin.analytics.trend_intro') }}</p>
        </div>
        @if ($dashboard['trend'])
            @php($maxTrendUsers = max(1, ...array_column($dashboard['trend'], 'users')))
            <div class="analytics-chart" role="img" aria-label="{{ __('admin.analytics.trend_title') }}">
                @foreach ($dashboard['trend'] as $point)
                    <div class="analytics-chart-column" title="{{ $point['date'] }} — {{ $point['users'] }}">
                        <strong>{{ $point['users'] }}</strong>
                        <span class="analytics-chart-track"><span style="height: {{ round($point['users'] / $maxTrendUsers * 100) }}%"></span></span>
                        <small>{{ $point['date'] }}</small>
                    </div>
                @endforeach
            </div>
        @else
            <p class="analytics-empty">{{ __('admin.analytics.no_data') }}</p>
        @endif
    </section>

    <div class="analytics-lists">
        <section class="admin-panel analytics-list-panel" aria-labelledby="analytics-pages-title">
            <div class="analytics-panel-heading"><h2 id="analytics-pages-title">{{ __('admin.analytics.top_pages') }}</h2></div>
            @forelse ($dashboard['pages'] as $page)
                <div class="analytics-list-row"><span title="{{ $page['path'] }}">{{ $page['path'] }}</span><strong>{{ $page['views'] }}</strong></div>
            @empty
                <p class="analytics-empty">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </section>
        <section class="admin-panel analytics-list-panel" aria-labelledby="analytics-countries-title">
            <div class="analytics-panel-heading"><h2 id="analytics-countries-title">{{ __('admin.analytics.top_countries') }}</h2></div>
            @forelse ($dashboard['countries'] as $country)
                <div class="analytics-list-row"><span>{{ $country['country'] }}</span><strong>{{ $country['users'] }}</strong></div>
            @empty
                <p class="analytics-empty">{{ __('admin.analytics.no_data') }}</p>
            @endforelse
        </section>
    </div>
@elseif ($loadError)
    <section class="admin-panel analytics-setup-panel" role="alert">
        <h2>{{ __('admin.analytics.load_error_title') }}</h2>
        <p>{{ __('admin.analytics.load_error_text') }}</p>
    </section>
@else
    <section class="admin-panel analytics-setup-panel" aria-labelledby="analytics-setup-title">
        <span class="admin-eyebrow">{{ __('admin.analytics.setup_eyebrow') }}</span>
        <h2 id="analytics-setup-title">{{ __('admin.analytics.setup_title') }}</h2>
        <p>{{ __('admin.analytics.setup_intro') }}</p>
        <div class="analytics-setup-status">{{ __('admin.analytics.setup_issue_'.$setupIssue) }}</div>
        <ol>
            <li>{{ __('admin.analytics.setup_step_property') }}</li>
            <li>{{ __('admin.analytics.setup_step_api') }}</li>
            <li>{{ __('admin.analytics.setup_step_access') }}</li>
            <li>{{ __('admin.analytics.setup_step_credentials') }}</li>
        </ol>
        <p class="analytics-setup-note">{{ __('admin.analytics.setup_secret_note') }}</p>
    </section>
@endif

<p class="analytics-consent-note">{{ __('admin.analytics.consent_text') }}</p>
@endsection
