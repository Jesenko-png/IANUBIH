@extends('layouts.admin')

@section('title', 'Uredi vijest')

@section('content')
<div class="admin-page-heading admin-page-heading-compact">
    <div>
        <a href="{{ route('admin.news.index') }}" class="admin-back-link">← Nazad na aktuelnosti</a>
        <h1>Uredi vijest</h1>
        <p>URL vijesti ostaje stabilan nakon izmjene naslova.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.news.update', $newsPost) }}" enctype="multipart/form-data" class="admin-form news-editor-form">
    @csrf
    @method('PUT')
    @include('admin.news.partials.form', ['post' => $newsPost])
</form>
@endsection
