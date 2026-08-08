<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>IANUBIH</title>
</head>

<body>

    <main>

        <nav aria-label="Izbor jezika">

            <a href="{{ route('home', ['locale' => 'bs']) }}">
                BHS
            </a>

            <a href="{{ route('home', ['locale' => 'en']) }}">
                ENG
            </a>

        </nav>

        <h1>IANUBIH</h1>

        <p>
            {{ __('messages.language_test') }}
        </p>

    </main>

</body>
</html>