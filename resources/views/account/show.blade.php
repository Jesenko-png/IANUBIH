@extends('layouts.admin')

@section('title', 'Moj nalog')

@section('content')
<div class="admin-page-heading">
    <div>
        <span class="admin-eyebrow">Korisnički nalog</span>
        <h1>{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->email }}</p>
    </div>
    @if (auth()->user()->canManageNews())
        <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-primary">Otvori aktuelnosti</a>
    @endif
</div>

<section class="admin-panel account-status-card">
    @if (auth()->user()->isSuperAdmin())
        <span class="account-role account-role-super">Glavni administrator</span>
        <h2>Imate potpuni pristup administraciji.</h2>
        <p>Možete objavljivati aktuelnosti i odobravati drugim korisnicima administratorsko pravo.</p>
        <a href="{{ route('admin.users.index') }}" class="admin-button admin-button-secondary">Upravljanje korisnicima</a>
    @elseif (auth()->user()->canManageNews())
        <span class="account-role account-role-admin">Administrator</span>
        <h2>Odobreno vam je objavljivanje.</h2>
        <p>Možete kreirati, uređivati i brisati vijesti u modulu Aktuelnosti.</p>
        <a href="{{ route('admin.news.index') }}" class="admin-button admin-button-secondary">Otvori CMS</a>
    @else
        <span class="account-role account-role-member">Korisnik</span>
        <h2>Nalog čeka administratorsko odobrenje.</h2>
        <p>Možete se prijaviti na nalog, ali još nemate pristup objavljivanju. Glavni administrator mora vam dodijeliti ulogu administratora.</p>
    @endif
</section>
@endsection
