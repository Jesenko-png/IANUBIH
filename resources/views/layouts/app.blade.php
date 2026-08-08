@php
    $seoRouteName = request()->route()?->getName() ?? 'home';
    $seoRouteParameters = request()->route()?->parameters() ?? [];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="@yield('description', __('home.meta.description'))">

    <title>@yield('title', 'IANUBIH')</title>

    <link rel="canonical" href="{{ route($seoRouteName, $seoRouteParameters) }}">
    <link rel="alternate" hreflang="bs" href="{{ route($seoRouteName, array_merge($seoRouteParameters, ['locale' => 'bs'])) }}">
    <link rel="alternate" hreflang="en" href="{{ route($seoRouteName, array_merge($seoRouteParameters, ['locale' => 'en'])) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:opsz,wght@8..60,500;8..60,600;8..60,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/new-event/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/new-event/css/ianubih.css') }}">

    @stack('styles')
</head>
<body id="back-top" data-spy="scroll" data-offset="140" data-target=".navbar-collapse">

    <div class="preloader">
        <div class="sk-rotating-plane"></div>
    </div>

    @include('partials.navigation')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <a href="#back-top" class="go-top" aria-label="{{ __('home.footer.back_to_top') }}">
        <i class="fa fa-angle-up"></i>
    </a>

    <script src="{{ asset('assets/new-event/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/jquery.parallax.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/custom.js') }}"></script>
    <script src="{{ asset('assets/new-event/js/ianubih.js') }}"></script>

    @stack('scripts')
</body>
</html>
