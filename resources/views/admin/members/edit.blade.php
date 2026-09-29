@extends('layouts.admin')

@section('title', __('members.admin.edit_title'))

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.members.index') }}" class="admin-back-link">← {{ __('members.admin.back') }}</a>
        <h1>{{ __('members.admin.edit_title') }}</h1>
        <p>{{ __('members.admin.edit_intro') }}</p>
    </div>
</div>
<form method="POST" action="{{ route('admin.members.update', $member) }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @method('PUT')
    @include('admin.members.form')
</form>
@endsection
