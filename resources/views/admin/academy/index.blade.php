@extends('layouts.admin')
@section('title', __('academy_cms.title'))
@section('content')
<div class="admin-page-heading"><div><h1>{{ __('academy_cms.title') }}</h1><p>{{ __('academy_cms.intro') }}</p></div></div>
@unless ($storageReady)
    <div class="admin-alert admin-alert-error">{{ __('academy_cms.setup') }}</div>
@else
    <section class="admin-panel">
        @foreach ($pages as $page)
            <article class="admin-news-row">
                <div class="admin-news-copy"><h2>{{ $page === 'about' ? __('academy_cms.overview') : __('sections.pages.academy.'.$page.'.title') }}</h2></div>
                <a class="admin-button admin-button-secondary" href="{{ route('admin.academy.edit', $page) }}">{{ __('academy_cms.edit') }}</a>
            </article>
        @endforeach
    </section>
@endunless
@endsection
