@extends('layouts.admin')

@section('title', 'Nova vijest')

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.news.index') }}" class="admin-back-link">← Nazad na aktuelnosti</a>
        <h1>Nova vijest</h1>
        <p>Unesite obje jezičke verzije prije čuvanja.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="admin-form news-editor-form">
    @csrf
    @include('admin.news.partials.form')
</form>
@endsection
