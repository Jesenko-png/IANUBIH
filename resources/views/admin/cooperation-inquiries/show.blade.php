@extends('layouts.admin')

@section('title', $cooperationInquiry->initiative_title)

@section('content')
<div class="admin-page-heading admin-page-heading-compact inquiry-detail-heading">
    <div>
        <a href="{{ route('admin.cooperation-inquiries.index') }}" class="admin-back-link">← {{ __('cooperation.admin.back') }}</a>
        <div class="inquiry-detail-status">
            <span class="inquiry-status">{{ __('cooperation.admin.status_viewed') }}</span>
            <time datetime="{{ $cooperationInquiry->created_at->toIso8601String() }}">{{ $cooperationInquiry->created_at->format('d.m.Y. H:i') }}</time>
        </div>
        <h1>{{ $cooperationInquiry->initiative_title }}</h1>
        <p>{{ __('cooperation.admin.submitted_by', ['name' => $cooperationInquiry->name]) }}</p>
    </div>
    <a href="mailto:{{ $cooperationInquiry->email }}?subject={{ rawurlencode(__('cooperation.admin.reply_subject', ['title' => $cooperationInquiry->initiative_title])) }}" class="admin-button admin-button-primary">{{ __('cooperation.admin.reply') }}</a>
</div>

<div class="inquiry-detail-grid">
    <section class="admin-panel inquiry-message-panel" aria-labelledby="inquiry-message-title">
        <span class="admin-eyebrow">{{ __('cooperation.admin.proposal') }}</span>
        <h2 id="inquiry-message-title">{{ __('cooperation.admin.message') }}</h2>
        <div class="inquiry-message">{!! nl2br(e($cooperationInquiry->message)) !!}</div>
    </section>

    <aside class="admin-panel inquiry-meta-panel" aria-label="{{ __('cooperation.admin.details') }}">
        <h2>{{ __('cooperation.admin.details') }}</h2>
        <dl class="inquiry-meta-list">
            <div>
                <dt>{{ __('cooperation.admin.name') }}</dt>
                <dd>{{ $cooperationInquiry->name }}</dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.email') }}</dt>
                <dd><a href="mailto:{{ $cooperationInquiry->email }}">{{ $cooperationInquiry->email }}</a></dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.organization') }}</dt>
                <dd>{{ $cooperationInquiry->organization ?: __('cooperation.admin.not_provided') }}</dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.partner_type') }}</dt>
                <dd>{{ __('cooperation.form.partner_types.'.$cooperationInquiry->partner_type) }}</dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.language') }}</dt>
                <dd>{{ strtoupper($cooperationInquiry->locale) }}</dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.submitted_at') }}</dt>
                <dd>{{ $cooperationInquiry->created_at->format('d.m.Y. H:i') }}</dd>
            </div>
            <div>
                <dt>{{ __('cooperation.admin.viewed_at') }}</dt>
                <dd>{{ $cooperationInquiry->viewed_at?->format('d.m.Y. H:i') }}</dd>
            </div>
            @if ($cooperationInquiry->viewer)
                <div>
                    <dt>{{ __('cooperation.admin.viewed_by') }}</dt>
                    <dd>{{ $cooperationInquiry->viewer->name }}</dd>
                </div>
            @endif
        </dl>
    </aside>
</div>
@endsection
