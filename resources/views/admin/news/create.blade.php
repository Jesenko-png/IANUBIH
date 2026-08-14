@extends('layouts.admin')

@section('title', __('admin.news.create_title'))

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.news.index') }}" class="admin-back-link">← {{ __('admin.news.back') }}</a>
        <h1>{{ __('admin.news.create_title') }}</h1>
        <p>{{ __('admin.news.create_intro') }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="admin-form news-editor-form">
    @csrf
    @include('admin.news.partials.form')
</form>
@endsection
