<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', __('account.administration')) | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a class="admin-brand" href="{{ auth()->user()->canManageNews() ? route('admin.news.index') : route('account.show') }}">
            <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
            <span><strong>IANUBIH</strong><small>{{ auth()->user()->canManageNews() ? __('account.content_administration') : __('account.user_account') }}</small></span>
        </a>

        <nav class="admin-nav" aria-label="{{ __('account.administration') }}">
            @if (auth()->user()->canManageNews())
                <a href="{{ route('admin.news.index') }}" @class(['active' => request()->routeIs('admin.news.*')])>{{ __('account.news') }}</a>
                <a href="{{ route('admin.cooperation-inquiries.index') }}" @class(['active' => request()->routeIs('admin.cooperation-inquiries.*')])>{{ __('cooperation.admin.navigation') }}</a>
            @endif
            @if (auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>{{ __('account.users') }}</a>
            @endif
            <a href="{{ route('account.show', ['locale' => app()->getLocale()]) }}" @class(['active' => request()->routeIs('account.*')])>{{ __('account.my_account') }}</a>
            <a href="{{ route('news', ['locale' => app()->getLocale()]) }}" target="_blank" rel="noopener">{{ __('account.open_website') }}</a>
            <span class="admin-language-switcher" aria-label="{{ __('auth.language') }}">
                <a href="{{ request()->fullUrlWithQuery(['locale' => 'bs']) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs" aria-label="Bosanski">BS</a>
                <a href="{{ request()->fullUrlWithQuery(['locale' => 'en']) }}" @class(['active' => app()->getLocale() === 'en']) lang="en" aria-label="English">EN</a>
            </span>
            <span class="admin-user">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                <button type="submit" class="admin-link-button">{{ __('account.logout') }}</button>
            </form>
        </nav>
    </header>

    <main class="admin-main">
        @if (session('status'))
            <div class="admin-alert admin-alert-success" role="status">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="admin-alert admin-alert-error" role="alert">
                <strong>{{ __('account.check_data') }}</strong>
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
