@extends('layouts.admin')

@section('title', __('admin.news.index_title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('admin.news.eyebrow') }}</span>
        <h1>{{ __('admin.news.index_title') }}</h1>
        <p>{{ __('admin.news.index_intro') }}</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="admin-button admin-button-primary">{{ __('admin.news.new') }}</a>
</div>

<section class="admin-panel" aria-label="{{ __('admin.news.list_label') }}">
    @if ($newsPosts->isEmpty())
        <div class="admin-empty">
            <span>01</span>
            <h2>{{ __('admin.news.empty_title') }}</h2>
            <p>{{ __('admin.news.empty_text') }}</p>
            <a href="{{ route('admin.news.create') }}" class="admin-button admin-button-primary">{{ __('admin.news.add_first') }}</a>
        </div>
    @else
        <div class="admin-news-list">
            @foreach ($newsPosts as $post)
                @php
                    $isScheduled = $post->status === 'published'
                        && $post->published_at
                        && $post->published_at->isFuture();
                @endphp
                <article class="admin-news-row">
                    <img src="{{ Storage::url($post->image_path) }}" alt="">
                    <div class="admin-news-copy">
                        <div class="admin-news-meta">
                            <span @class([
                                'status-badge',
                                'status-published' => $post->isPublished(),
                                'status-scheduled' => $isScheduled,
                                'status-draft' => ! $post->isPublished() && ! $isScheduled,
                            ])>
                                {{ $post->isPublished() ? __('admin.news.status_published') : ($isScheduled ? __('admin.news.status_scheduled') : __('admin.news.status_draft')) }}
                            </span>
                            <span>{{ $post->localized('category') }}</span>
                            <span>{{ optional($post->published_at)->format('d.m.Y. H:i') ?: __('admin.news.no_publication_date') }}</span>
                        </div>
                        <h2>{{ $post->localized('title') }}</h2>
                        <p>{{ $post->localized('excerpt') }}</p>
                        <small>{{ __('admin.news.last_updated', ['date' => $post->updated_at->format('d.m.Y. H:i')]) }}@if($post->author) · {{ $post->author->name }}@endif</small>
                    </div>
                    <div class="admin-news-actions">
                        @if ($post->isPublished())
                            <a href="{{ route('news.show', ['locale' => app()->getLocale(), 'newsPost' => $post]) }}" target="_blank" rel="noopener" class="admin-button admin-button-secondary">{{ __('admin.news.view') }}</a>
                        @endif
                        <a href="{{ route('admin.news.edit', $post) }}" class="admin-button admin-button-secondary">{{ __('admin.news.edit') }}</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm(@js(__('admin.news.delete_confirm')))">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-button admin-button-danger">{{ __('admin.news.delete') }}</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($newsPosts->hasPages())
            <nav class="admin-pagination" aria-label="{{ __('admin.news.pages') }}">
                @if ($newsPosts->onFirstPage())
                    <span>{{ __('admin.common.previous') }}</span>
                @else
                    <a href="{{ $newsPosts->previousPageUrl() }}">{{ __('admin.common.previous') }}</a>
                @endif
                <strong>{{ $newsPosts->currentPage() }} / {{ $newsPosts->lastPage() }}</strong>
                @if ($newsPosts->hasMorePages())
                    <a href="{{ $newsPosts->nextPageUrl() }}">{{ __('admin.common.next') }}</a>
                @else
                    <span>{{ __('admin.common.next') }}</span>
                @endif
            </nav>
        @endif
    @endif
</section>
@endsection
