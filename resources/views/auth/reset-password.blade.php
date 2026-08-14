<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('auth.reset_page_title') }} | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-card" aria-labelledby="reset-password-title">
            <nav class="login-language-switcher" aria-label="{{ __('auth.language') }}">
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email, 'locale' => 'bs']) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BS</a>
                <a href="{{ route('password.reset', ['token' => $token, 'email' => $email, 'locale' => 'en']) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">EN</a>
            </nav>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="login-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
                <span>IANUBIH</span>
            </a>
            <p class="login-eyebrow">{{ __('auth.reset_eyebrow') }}</p>
            <h1 id="reset-password-title">{{ __('auth.reset_heading') }}</h1>
            <p class="login-intro">{{ __('auth.reset_intro') }}</p>

            @if ($errors->any())
                <div class="admin-alert admin-alert-error" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="admin-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                <div class="form-field">
                    <label for="email">{{ __('auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" autocomplete="email" required autofocus>
                </div>
                <div class="form-field">
                    <label for="password">{{ __('auth.new_password') }}</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" required>
                    <small class="field-help">{{ __('auth.password_help') }}</small>
                </div>
                <div class="form-field">
                    <label for="password_confirmation">{{ __('auth.confirm_password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                </div>
                <button type="submit" class="admin-button admin-button-primary admin-button-block">{{ __('auth.update_password') }}</button>
            </form>

            <a class="auth-back-link" href="{{ route('login', ['locale' => app()->getLocale()]) }}">{{ __('auth.back_to_login') }}</a>
        </section>
    </main>
</body>
</html>
