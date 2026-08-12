<!DOCTYPE html>
<html lang="bs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Prijava | IANUBIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/admin.css') }}?v={{ filemtime(public_path('assets/new-event/css/admin.css')) }}">
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-card" aria-labelledby="login-title">
            <a href="{{ route('home', ['locale' => 'bs']) }}" class="login-brand">
                <img src="{{ asset('assets/new-event/images/logo.jpg') }}" alt="IANUBIH">
                <span>IANUBIH</span>
            </a>
            <p class="login-eyebrow">Korisnički pristup</p>
            <h1 id="login-title">Prijava</h1>
            <p class="login-intro">Prijavite se na svoj IANUBIH nalog ili kreirajte novi.</p>

            @if ($errors->login->any())
                <div class="admin-alert admin-alert-error" role="alert">{{ $errors->login->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="admin-form">
                @csrf
                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                </div>
                <div class="form-field">
                    <label for="password">Lozinka</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" required>
                </div>
                <label class="checkbox-field">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ostani prijavljen</span>
                </label>
                <button type="submit" class="admin-button admin-button-primary admin-button-block">Prijavi se</button>
            </form>

            <details class="register-disclosure" @if($errors->register->any()) open @endif>
                <summary>
                    <span>Nemate korisnički nalog?</span>
                    <strong>Kreiraj nalog</strong>
                </summary>

                <div class="register-panel">
                    <p>Novi nalog nema pravo objavljivanja dok ga glavni administrator ne odobri. Prvi nalog u sistemu automatski postaje glavni administrator.</p>

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
                            <div class="form-field">
                                <label for="name">Ime i prezime</label>
                                <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="255" required>
                            </div>
                            <div class="form-field">
                                <label for="register_email">Email</label>
                                <input id="register_email" type="email" name="register_email" value="{{ old('register_email') }}" autocomplete="email" required>
                            </div>
                            <div class="form-field">
                                <label for="register_password">Lozinka</label>
                                <input id="register_password" type="password" name="register_password" autocomplete="new-password" required>
                                <small class="field-help">Najmanje 10 znakova, jedno slovo i jedan broj.</small>
                            </div>
                            <div class="form-field">
                                <label for="register_password_confirmation">Ponovite lozinku</label>
                                <input id="register_password_confirmation" type="password" name="register_password_confirmation" autocomplete="new-password" required>
                            </div>
                            <button type="submit" class="admin-button admin-button-primary admin-button-block">Kreiraj nalog</button>
                    </form>
                </div>
            </details>
        </section>
    </main>
</body>
</html>
