<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('partials.favicon')
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>IASABIH</title>
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

        <h1>IASABIH</h1>

        <p>
            {{ __('messages.language_test') }}
        </p>

    </main>

</body>
</html>
