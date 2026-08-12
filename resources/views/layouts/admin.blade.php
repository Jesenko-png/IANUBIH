<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Administracija') | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a class="admin-brand" href="{{ auth()->user()->canManageNews() ? route('admin.news.index') : route('account.show') }}">
            <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
            <span><strong>IANUBIH</strong><small>{{ auth()->user()->canManageNews() ? 'Administracija sadržaja' : 'Korisnički nalog' }}</small></span>
        </a>

        <nav class="admin-nav" aria-label="Administracija">
            @if (auth()->user()->canManageNews())
                <a href="{{ route('admin.news.index') }}" @class(['active' => request()->routeIs('admin.news.*')])>Aktuelnosti</a>
            @endif
            @if (auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>Korisnici</a>
            @endif
            <a href="{{ route('account.show') }}" @class(['active' => request()->routeIs('account.*')])>Moj nalog</a>
            <a href="{{ route('news', ['locale' => 'bs']) }}" target="_blank" rel="noopener">Otvori web stranicu</a>
            <span class="admin-user">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-link-button">Odjava</button>
            </form>
        </nav>
    </header>

    <main class="admin-main">
        @if (session('status'))
            <div class="admin-alert admin-alert-success" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="admin-alert admin-alert-error" role="alert">
                <strong>Provjerite unesene podatke:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
