@extends('layouts.admin')

@section('title', 'Korisnici')

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">Dozvole</span>
        <h1>Korisnici</h1>
        <p>Samo glavni administrator može odobriti ili ukloniti pravo objavljivanja.</p>
    </div>
</div>

<section class="admin-panel users-panel" aria-label="Korisnički nalozi">
    <div class="permission-legend">
        <div><strong>Korisnik</strong><span>Nema pristup CMS-u</span></div>
        <div><strong>Administrator</strong><span>Može objavljivati i uređivati vijesti</span></div>
        <div><strong>Glavni administrator</strong><span>Upravlja vijestima i dozvolama</span></div>
    </div>

    <div class="user-list">
        @foreach ($users as $user)
            <article class="user-row">
                <div class="user-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div class="user-identity">
                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>
                    <small>Kreiran {{ $user->created_at->format('d.m.Y. H:i') }}</small>
                </div>

                @if ($user->isSuperAdmin())
                    <span class="account-role account-role-super">Glavni administrator</span>
                @else
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="user-role-form">
                        @csrf
                        @method('PATCH')
                        <label for="role-{{ $user->id }}">Uloga</label>
                        <select id="role-{{ $user->id }}" name="role">
                            <option value="member" @selected($user->role === 'member')>Korisnik</option>
                            <option value="admin" @selected($user->role === 'admin')>Administrator</option>
                        </select>
                        <button type="submit" class="admin-button admin-button-primary">Sačuvaj dozvolu</button>
                    </form>
                @endif
            </article>
        @endforeach
    </div>

    @if ($users->hasPages())
        <nav class="admin-pagination" aria-label="Stranice korisnika">
            @if ($users->onFirstPage())
                <span>Prethodna</span>
            @else
                <a href="{{ $users->previousPageUrl() }}">Prethodna</a>
            @endif
            <strong>{{ $users->currentPage() }} / {{ $users->lastPage() }}</strong>
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}">Sljedeća</a>
            @else
                <span>Sljedeća</span>
            @endif
        </nav>
    @endif
</section>
@endsection
