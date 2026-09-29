@extends('layouts.admin')

@section('title', __('members.admin.create_title'))

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.members.index') }}" class="admin-back-link">← {{ __('members.admin.back') }}</a>
        <h1>{{ __('members.admin.create_title') }}</h1>
        <p>{{ __('members.admin.create_intro') }}</p>
    </div>
</div>
<form method="POST" action="{{ route('admin.members.store') }}" enctype="multipart/form-data" class="admin-form">
    @csrf
    @include('admin.members.form')
</form>
@endsection
