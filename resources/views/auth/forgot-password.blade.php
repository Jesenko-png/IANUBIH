<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('auth.forgot_page_title') }} | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-card" aria-labelledby="forgot-password-title">
            <nav class="login-language-switcher" aria-label="{{ __('auth.language') }}">
                <a href="{{ route('password.request', ['locale' => 'bs']) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BS</a>
                <a href="{{ route('password.request', ['locale' => 'en']) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">EN</a>
            </nav>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="login-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
                <span>IANUBIH</span>
            </a>
            <p class="login-eyebrow">{{ __('auth.forgot_eyebrow') }}</p>
            <h1 id="forgot-password-title">{{ __('auth.forgot_heading') }}</h1>
            <p class="login-intro">{{ __('auth.forgot_intro') }}</p>

            @if (session('status'))
                <div class="admin-alert admin-alert-success" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="admin-alert admin-alert-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="admin-form">
                @csrf
                <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                <div class="form-field">
                    <label for="email">{{ __('auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                </div>
                <button type="submit" class="admin-button admin-button-primary admin-button-block">{{ __('auth.send_reset_link') }}</button>
            </form>

            <a class="auth-back-link" href="{{ route('login', ['locale' => app()->getLocale()]) }}">{{ __('auth.back_to_login') }}</a>
        </section>
    </main>
</body>
</html>
