@extends('layouts.admin')
@section('title', __('projects_cms.edit_title'))

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a class="admin-back-link" href="{{ route('admin.projects.index') }}">← {{ __('projects_cms.back') }}</a>
        <h1>{{ __('projects_cms.edit_title') }}</h1>
        <p>{{ __('projects_cms.edit_intro') }}</p>
    </div>
</div>
<form method="POST" action="{{ route('admin.projects.update', $project) }}" class="admin-form">
    @csrf
    @method('PUT')
    @include('admin.projects.form')
</form>
@endsection
