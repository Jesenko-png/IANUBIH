@extends('layouts.admin')
@section('title', __('organization_cms.title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('organization_cms.eyebrow') }}</span>
        <h1>{{ __('organization_cms.title') }}</h1>
        <p>{{ __('organization_cms.intro') }}</p>
    </div>
</div>

@unless ($storageReady)
    <div class="admin-alert admin-alert-error">{{ __('organization_cms.setup') }}</div>
@else
    <section class="admin-panel organization-cms-list">
        @foreach ($pages as $page)
            <article class="admin-news-row organization-cms-row {{ $page['item'] ? 'organization-cms-child' : '' }}">
                <div class="organization-cms-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="admin-news-copy">
                    @if ($page['item'])
                        <small>{{ __('sections.pages.organization.'.$page['topic'].'.title') }}</small>
                    @endif
                    <h2>{{ $page['title'] }}</h2>
                </div>
                <a class="admin-button admin-button-secondary" href="{{ route('admin.organization.edit', array_filter(['topic' => $page['topic'], 'item' => $page['item']])) }}">{{ __('organization_cms.edit') }}</a>
            </article>
        @endforeach
    </section>
@endunless
@endsection
