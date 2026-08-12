@extends('layouts.admin')

@section('title', 'Aktuelnosti')

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">CMS modul</span>
        <h1>Aktuelnosti</h1>
        <p>Kreirajte, uredite i objavite vijesti na bosanskom i engleskom jeziku.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="admin-button admin-button-primary">Nova vijest</a>
</div>

<section class="admin-panel" aria-label="Spisak vijesti">
    @if ($newsPosts->isEmpty())
        <div class="admin-empty">
            <span>01</span>
            <h2>Još nema vijesti</h2>
            <p>Dodajte prvu vijest i sačuvajte je kao nacrt ili je odmah objavite.</p>
            <a href="{{ route('admin.news.create') }}" class="admin-button admin-button-primary">Dodaj prvu vijest</a>
        </div>
    @else
        <div class="admin-news-list">
            @foreach ($newsPosts as $post)
                @php
                    $isScheduled = $post->status === 'published'
                        && $post->published_at
                        && $post->published_at->isFuture();
                @endphp
                <article class="admin-news-row">
                    <img src="{{ Storage::url($post->image_path) }}" alt="">
                    <div class="admin-news-copy">
                        <div class="admin-news-meta">
                            <span @class([
                                'status-badge',
                                'status-published' => $post->isPublished(),
                                'status-scheduled' => $isScheduled,
                                'status-draft' => ! $post->isPublished() && ! $isScheduled,
                            ])>
                                {{ $post->isPublished() ? 'Objavljeno' : ($isScheduled ? 'Zakazano' : 'Nacrt') }}
                            </span>
                            <span>{{ $post->category_bs }}</span>
                            <span>{{ optional($post->published_at)->format('d.m.Y. H:i') ?: 'Bez datuma objave' }}</span>
                        </div>
                        <h2>{{ $post->title_bs }}</h2>
                        <p>{{ $post->excerpt_bs }}</p>
                        <small>Zadnja izmjena: {{ $post->updated_at->format('d.m.Y. H:i') }}@if($post->author) · {{ $post->author->name }}@endif</small>
                    </div>
                    <div class="admin-news-actions">
                        @if ($post->isPublished())
                            <a href="{{ route('news.show', ['locale' => 'bs', 'newsPost' => $post]) }}" target="_blank" rel="noopener" class="admin-button admin-button-secondary">Pregled</a>
                        @endif
                        <a href="{{ route('admin.news.edit', $post) }}" class="admin-button admin-button-secondary">Uredi</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $post) }}" onsubmit="return confirm('Trajno obrisati ovu vijest?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-button admin-button-danger">Obriši</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($newsPosts->hasPages())
            <nav class="admin-pagination" aria-label="Stranice">
                @if ($newsPosts->onFirstPage())
                    <span>Prethodna</span>
                @else
                    <a href="{{ $newsPosts->previousPageUrl() }}">Prethodna</a>
                @endif
                <strong>{{ $newsPosts->currentPage() }} / {{ $newsPosts->lastPage() }}</strong>
                @if ($newsPosts->hasMorePages())
                    <a href="{{ $newsPosts->nextPageUrl() }}">Sljedeća</a>
                @else
                    <span>Sljedeća</span>
                @endif
            </nav>
        @endif
    @endif
</section>
@endsection
