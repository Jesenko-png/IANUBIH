<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('auth.page_title') }} | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-card" aria-labelledby="login-title">
            <nav class="login-language-switcher" aria-label="{{ __('auth.language') }}">
                <a href="{{ route('login', ['locale' => 'bs']) }}" @class(['active' => app()->getLocale() === 'bs']) lang="bs">BS</a>
                <a href="{{ route('login', ['locale' => 'en']) }}" @class(['active' => app()->getLocale() === 'en']) lang="en">EN</a>
            </nav>

            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="login-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
                <span>IANUBIH</span>
            </a>
            <p class="login-eyebrow">{{ __('auth.eyebrow') }}</p>
            <h1 id="login-title">{{ __('auth.heading') }}</h1>
            <p class="login-intro">{{ __('auth.intro') }}</p>

            @if (session('status'))
                <div class="admin-alert admin-alert-success" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->login->any())
                <div class="admin-alert admin-alert-error" role="alert">{{ $errors->login->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="admin-form">
                @csrf
                <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                <div class="form-field">
                    <label for="email">{{ __('auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                </div>
                <div class="form-field">
                    <label for="password">{{ __('auth.password') }}</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" required>
                    <a class="forgot-password-link" href="{{ route('password.request', ['locale' => app()->getLocale()]) }}">{{ __('auth.forgot_link') }}</a>
                </div>
                <label class="checkbox-field">
                    <input type="checkbox" name="remember" value="1">
                    <span>{{ __('auth.remember') }}</span>
                </label>
                <button type="submit" class="admin-button admin-button-primary admin-button-block">{{ __('auth.submit') }}</button>
            </form>

            <details class="register-disclosure" @if($errors->register->any()) open @endif>
                <summary>
                    <span>{{ __('auth.no_account') }}</span>
                    <strong>{{ __('auth.create_account') }}</strong>
                </summary>

                <div class="register-panel">
                    @if ($errors->register->any())
                        <div class="admin-alert admin-alert-error" role="alert">
                            <ul>
                                @foreach ($errors->register->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" class="admin-form">
                            @csrf
                            <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
                            <div class="form-field">
                                <label for="name">{{ __('auth.full_name') }}</label>
                                <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required>
                            </div>
                            <div class="form-field">
                                <label for="register_email">{{ __('auth.email') }}</label>
                                <input id="register_email" type="email" name="register_email" value="{{ old('register_email') }}" autocomplete="email" required>
                            </div>
                            <div class="form-field">
                                <label for="register_password">{{ __('auth.password') }}</label>
                                <input id="register_password" type="password" name="register_password" autocomplete="new-password" required>
                                <small class="field-help">{{ __('auth.password_help') }}</small>
                            </div>
                            <div class="form-field">
                                <label for="register_password_confirmation">{{ __('auth.confirm_password') }}</label>
                                <input id="register_password_confirmation" type="password" name="register_password_confirmation" autocomplete="new-password" required>
                            </div>
                            <button type="submit" class="admin-button admin-button-primary admin-button-block">{{ __('auth.create_account') }}</button>
                    </form>
                </div>
            </details>
        </section>
    </main>
</body>
</html>
