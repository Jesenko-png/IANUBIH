@extends('layouts.admin')
@section('title', __('projects_cms.title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('projects_cms.eyebrow') }}</span>
        <h1>{{ __('projects_cms.title') }}</h1>
        <p>{{ __('projects_cms.intro') }}</p>
    </div>
    @if ($storageReady)
        <a href="{{ route('admin.projects.create') }}" class="admin-button admin-button-primary">{{ __('projects_cms.new') }}</a>
    @endif
</div>

@if (! $storageReady)
    <section class="admin-panel admin-empty">
        <span>01</span>
        <h2>{{ __('projects_cms.storage_title') }}</h2>
        <p>{{ auth()->user()->isSuperAdmin() ? __('projects_cms.storage_text_super') : __('projects_cms.storage_text_admin') }}</p>
        @if (auth()->user()->isSuperAdmin())
            <form method="POST" action="{{ route('admin.projects.setup') }}">
                @csrf
                <button class="admin-button admin-button-primary" type="submit">{{ __('projects_cms.storage_button') }}</button>
            </form>
        @endif
    </section>
@else
    <section class="admin-panel">
        @forelse ($projects as $project)
            <article class="admin-news-row organization-cms-row">
                <div class="organization-cms-number">{{ str_pad($loop->iteration + (($projects->currentPage() - 1) * $projects->perPage()), 2, '0', STR_PAD_LEFT) }}</div>
                <div class="admin-news-copy">
                    <div class="admin-news-meta">
                        <span @class(['status-badge', 'status-published' => $project->status === 'published', 'status-draft' => $project->status !== 'published'])>
                            {{ $project->status === 'published' ? __('projects_cms.published') : __('projects_cms.draft') }}
                        </span>
                        <span>{{ $project->project_status === 'active' ? __('projects_cms.active') : __('projects_cms.completed') }}</span>
                        <span>{{ $project->programme_bs }}</span>
                    </div>
                    <h2>{{ $project->title_bs }}</h2>
                    <p>{{ $project->summary_bs }}</p>
                </div>
                <div class="admin-news-actions">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="admin-button admin-button-secondary">{{ __('projects_cms.edit') }}</a>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm(@js(__('projects_cms.delete_confirm')))" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-button admin-button-danger">{{ __('projects_cms.delete') }}</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-empty">
                <span>01</span>
                <h2>{{ __('projects_cms.empty_title') }}</h2>
                <p>{{ __('projects_cms.empty_text') }}</p>
                <a href="{{ route('admin.projects.create') }}" class="admin-button admin-button-primary">{{ __('projects_cms.add_first') }}</a>
            </div>
        @endforelse
    </section>

    @if ($projects->hasPages())
        <nav class="admin-pagination">
            @if ($projects->onFirstPage())<span>{{ __('projects_cms.previous') }}</span>@else<a href="{{ $projects->previousPageUrl() }}">{{ __('projects_cms.previous') }}</a>@endif
            <strong>{{ $projects->currentPage() }} / {{ $projects->lastPage() }}</strong>
            @if ($projects->hasMorePages())<a href="{{ $projects->nextPageUrl() }}">{{ __('projects_cms.next') }}</a>@else<span>{{ __('projects_cms.next') }}</span>@endif
        </nav>
    @endif
@endif
@endsection
