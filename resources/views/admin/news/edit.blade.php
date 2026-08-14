@extends('layouts.admin')

@section('title', __('admin.news.edit_title'))

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.news.index') }}" class="admin-back-link">← {{ __('admin.news.back') }}</a>
        <h1>{{ __('admin.news.edit_title') }}</h1>
        <p>{{ __('admin.news.edit_intro') }}</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.news.update', $newsPost) }}" enctype="multipart/form-data" class="admin-form news-editor-form">
    @csrf
    @method('PUT')
    @include('admin.news.partials.form', ['post' => $newsPost])
</form>
@endsection
