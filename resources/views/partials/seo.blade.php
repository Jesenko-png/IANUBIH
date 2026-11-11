<meta property="og:site_name" content="IASABIH">
<meta property="og:title" content="@yield('title', 'IASABIH')">
<meta property="og:description" content="@yield('description', __('home.meta.description'))">
<meta property="og:url" content="{{ route($seoRouteName, $seoRouteParameters) }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ asset('favicon.png') }}">
<link rel="alternate" hreflang="x-default" href="{{ route($seoRouteName, array_merge($seoRouteParameters, ['locale' => 'bs'])) }}">
@if(request()->routeIs('home'))
    @php
        $siteRoot = url('/');
        $structuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => $siteRoot.'/#website',
                    'url' => $siteRoot.'/',
                    'name' => 'IASABIH',
                    'alternateName' => __('home.topbar.institution'),
                    'inLanguage' => ['bs', 'en'],
                    'publisher' => ['@id' => $siteRoot.'/#organization'],
                ],
                [
                    '@type' => 'Organization',
                    '@id' => $siteRoot.'/#organization',
                    'name' => __('home.topbar.institution'),
                    'alternateName' => 'IASABIH',
                    'url' => $siteRoot.'/',
                    'logo' => asset('favicon.png'),
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endif
