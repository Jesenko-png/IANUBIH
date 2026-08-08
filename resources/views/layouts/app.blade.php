<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="@yield('description', 'Internacionalna akademija nauka i umjetnosti u Bosni i Hercegovini')">

    <title>@yield('title', 'IANUBIH')</title>

    <link rel="stylesheet" href="{{ asset('assets/new-event/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600" rel="stylesheet">

    @stack('styles')
</head>
<body data-spy="scroll" data-offset="50" data-target=".navbar-collapse">

    <div class="preloader">
        <div class="sk-rotating-plane"></div>
    </div>

    @include('partials.navigation')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <a href="#back-top" class="go-top" aria-label="Back to top">
        <i class="fa fa-angle-up"></i>
    </a>

    <script src="{{ asset('assets/new-event/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/jquery.parallax.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/smoothscroll.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
