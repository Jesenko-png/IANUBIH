@extends('layouts.admin')

@section('title', __('cooperation.admin.index_title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('cooperation.admin.eyebrow') }}</span>
        <h1>{{ __('cooperation.admin.index_title') }}</h1>
        <p>{{ __('cooperation.admin.index_intro') }}</p>
    </div>
    @if ($storageReady)
        <div class="inquiry-summary" aria-label="{{ __('cooperation.admin.summary_label') }}">
            <span><strong>{{ $unreadCount }}</strong>{{ __('cooperation.admin.unread') }}</span>
            <span><strong>{{ $inquiries->total() }}</strong>{{ __('cooperation.admin.total') }}</span>
        </div>
    @endif
</div>

@if (! $storageReady)
    <section class="admin-panel inquiry-setup-panel" aria-labelledby="inquiry-setup-title">
        <span class="inquiry-setup-number">01</span>
        <div>
            <span class="admin-eyebrow">{{ __('cooperation.admin.storage_eyebrow') }}</span>
            <h2 id="inquiry-setup-title">{{ __('cooperation.admin.storage_title') }}</h2>
            <p>{{ auth()->user()->isSuperAdmin() ? __('cooperation.admin.storage_text_super') : __('cooperation.admin.storage_text_admin') }}</p>
        </div>
        @if (auth()->user()->isSuperAdmin())
            <form method="POST" action="{{ route('admin.cooperation-inquiries.setup') }}">
                @csrf
                <button type="submit" class="admin-button admin-button-primary">{{ __('cooperation.admin.storage_button') }}</button>
            </form>
        @endif
    </section>
@else
<section class="admin-panel inquiries-panel" aria-label="{{ __('cooperation.admin.list_label') }}">
    @if ($inquiries->isEmpty())
        <div class="admin-empty">
            <span>01</span>
            <h2>{{ __('cooperation.admin.empty_title') }}</h2>
            <p>{{ __('cooperation.admin.empty_text') }}</p>
            <a href="{{ route('cooperation', ['locale' => app()->getLocale()]) }}" target="_blank" rel="noopener" class="admin-button admin-button-primary">{{ __('cooperation.admin.open_page') }}</a>
        </div>
    @else
        <div class="inquiry-list">
            @foreach ($inquiries as $inquiry)
                <article @class(['inquiry-row', 'inquiry-row-unread' => $inquiry->isUnread()])>
                    <div class="inquiry-status-column">
                        <span @class(['inquiry-status', 'inquiry-status-new' => $inquiry->isUnread()])>
                            {{ $inquiry->isUnread() ? __('cooperation.admin.status_new') : __('cooperation.admin.status_viewed') }}
                        </span>
                        <time datetime="{{ $inquiry->created_at->toIso8601String() }}">{{ $inquiry->created_at->format('d.m.Y. H:i') }}</time>
                    </div>

                    <div class="inquiry-list-copy">
                        <div class="inquiry-list-meta">
                            <span>{{ __('cooperation.form.partner_types.'.$inquiry->partner_type) }}</span>
                            <span>{{ strtoupper($inquiry->locale) }}</span>
                        </div>
                        <h2>{{ $inquiry->initiative_title }}</h2>
                        <p>{{ $inquiry->message }}</p>
                        <small>
                            {{ $inquiry->name }}
                            @if ($inquiry->organization)
                                · {{ $inquiry->organization }}
                            @endif
                        </small>
                    </div>

                    <a href="{{ route('admin.cooperation-inquiries.show', $inquiry) }}" class="admin-button admin-button-secondary">{{ __('cooperation.admin.view') }}</a>
                </article>
            @endforeach
        </div>

        @if ($inquiries->hasPages())
            <nav class="admin-pagination" aria-label="{{ __('cooperation.admin.pages') }}">
                @if ($inquiries->onFirstPage())
                    <span>{{ __('cooperation.admin.previous') }}</span>
                @else
                    <a href="{{ $inquiries->previousPageUrl() }}">{{ __('cooperation.admin.previous') }}</a>
                @endif
                <strong>{{ $inquiries->currentPage() }} / {{ $inquiries->lastPage() }}</strong>
                @if ($inquiries->hasMorePages())
                    <a href="{{ $inquiries->nextPageUrl() }}">{{ __('cooperation.admin.next') }}</a>
                @else
                    <span>{{ __('cooperation.admin.next') }}</span>
                @endif
            </nav>
        @endif
    @endif
</section>
@endif
@endsection
