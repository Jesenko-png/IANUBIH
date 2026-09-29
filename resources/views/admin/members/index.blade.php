@extends('layouts.admin')

@section('title', __('members.admin.index_title'))

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">{{ __('members.admin.eyebrow') }}</span>
        <h1>{{ __('members.admin.index_title') }}</h1>
        <p>{{ __('members.admin.index_intro') }}</p>
    </div>
    @if ($storageReady)
        <a href="{{ route('admin.members.create') }}" class="admin-button admin-button-primary">{{ __('members.admin.new') }}</a>
    @endif
</div>

@if (! $storageReady)
    <section class="admin-panel admin-empty" aria-labelledby="members-setup-title">
        <span>01</span>
        <h2 id="members-setup-title">{{ __('members.admin.storage_title') }}</h2>
        <p>{{ auth()->user()->isSuperAdmin() ? __('members.admin.storage_text_super') : __('members.admin.storage_text_admin') }}</p>
        @if (auth()->user()->isSuperAdmin())
            <form method="POST" action="{{ route('admin.members.setup') }}">
                @csrf
                <button type="submit" class="admin-button admin-button-primary">{{ __('members.admin.storage_button') }}</button>
            </form>
        @endif
    </section>
@else
    <section class="admin-panel" aria-label="{{ __('members.admin.list_label') }}">
        @if ($members->isEmpty())
            <div class="admin-empty">
                <span>01</span>
                <h2>{{ __('members.admin.empty_title') }}</h2>
                <p>{{ __('members.admin.empty_text') }}</p>
                <a href="{{ route('admin.members.create') }}" class="admin-button admin-button-primary">{{ __('members.admin.add_first') }}</a>
            </div>
        @else
            <div class="admin-news-list">
                @foreach ($members as $member)
                    <article class="admin-news-row admin-member-row">
                        @if ($member->photo_path)
                            <img src="{{ Storage::url($member->photo_path) }}" alt="">
                        @else
                            <div class="admin-member-avatar" aria-hidden="true"><i class="fa fa-user"></i></div>
                        @endif
                        <div class="admin-news-copy">
                            <div class="admin-news-meta">
                                <span @class(['status-badge', 'status-published' => $member->isPublished(), 'status-draft' => ! $member->isPublished()])>
                                    {{ $member->isPublished() ? __('members.admin.published') : __('members.admin.draft') }}
                                </span>
                                @if ($member->localized('category'))<span>{{ $member->localized('category') }}</span>@endif
                                <span>{{ $member->localized('field') }}</span>
                            </div>
                            <h2>{{ trim($member->academic_title.' '.$member->name) }}</h2>
                            @if ($member->localized('position'))<p>{{ $member->localized('position') }}</p>@endif
                            <small>{{ $member->localized('institution') }}@if($member->localized('country')) · {{ $member->localized('country') }}@endif</small>
                        </div>
                        <div class="admin-news-actions">
                            @if ($member->isPublished())
                                <a href="{{ route('people.show', ['locale' => app()->getLocale(), 'slug' => $member->slug]) }}" target="_blank" rel="noopener" class="admin-button admin-button-secondary">{{ __('members.admin.view') }}</a>
                            @endif
                            <a href="{{ route('admin.members.edit', $member) }}" class="admin-button admin-button-secondary">{{ __('members.admin.edit') }}</a>
                            <form method="POST" action="{{ route('admin.members.destroy', $member) }}" onsubmit="return confirm(@js(__('members.admin.delete_confirm')))" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-button admin-button-danger">{{ __('members.admin.delete') }}</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($members->hasPages())
                <nav class="admin-pagination" aria-label="{{ __('members.admin.pages') }}">
                    @if ($members->onFirstPage())<span>{{ __('members.admin.previous') }}</span>@else<a href="{{ $members->previousPageUrl() }}">{{ __('members.admin.previous') }}</a>@endif
                    <strong>{{ $members->currentPage() }} / {{ $members->lastPage() }}</strong>
                    @if ($members->hasMorePages())<a href="{{ $members->nextPageUrl() }}">{{ __('members.admin.next') }}</a>@else<span>{{ __('members.admin.next') }}</span>@endif
                </nav>
            @endif
        @endif
    </section>
@endif
@endsection
