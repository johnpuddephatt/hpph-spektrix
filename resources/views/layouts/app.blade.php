<!DOCTYPE html>
<html class="scroll-smooth antialiased">
<!-- 2xl:text-lg -->

<head>

    @production
        @includeWhen(isset($settings['google_analytics']), 'analytics')
    @endproduction

    <title>@yield('title', config('app.description')) | Hyde Park Picture House (HPPH) Leeds</title>
    <meta name="description" content="@yield('description', config('app.description'))" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="@yield('canonical', Request::url())" />

    <meta property="og:image" content="@yield('image')" />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')" />
    <script type="application/ld+json">
    {
        "@type": "MovieTheater",
        "name": "Hyde Park Picture House",
        "alternateName": ["HPPH", "Hyde Park Picture House HPPH"],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "73 Brudenell Road",
            "addressLocality": "Leeds",
            "addressRegion": "West Yorkshire",
            "postalCode": "LS6 1JD",
            "addressCountry": "GB"
        }
    }
    </script>

    <link rel="shortcut icon" type="image/png" href="{{ Storage::disk('digitalocean')->url('favicon.png') }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @if ($__env->yieldPushContent('webComponents'))
        <script
            src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/scripts/integrate.js">
        </script>

        <script src="https://webcomponents.spektrix.com/stable/webcomponents-loader.js"></script>
        <script src="https://webcomponents.spektrix.com/stable/spektrix-component-loader.js"
            data-components="{{ trim(implode(',', explode('#', $__env->yieldPushContent('webComponents'))), ',') }}" async>
        </script>
    @endif

    @stack('head')
</head>

<body
    class="{{ $settings['alert_enabled'] && $settings['alert_display_until'] > now() ? 'pt-8 lg:pt-0' : '' }} bg-white leading-[162.5%] tracking-normal text-black transition-colors duration-300 ease-in-out dark:bg-black dark:text-white"
    :class="{ 'overflow-hidden': nav_open || booking_path_open || search_open }" x-data="{ scrolled: false, search_open: false, nav_open: false, booking_path_open: false }"
    @navtoggled.window="nav_open = $event.detail" @searchtoggled.window="search_open = $event.detail"
    @booking.window="console.log('booking event on window');booking_path_open = $event.detail"
    @scrolled.window="scrolled =  $event.detail;">
    @yield('templatecontent')
    @stack('footer')

    @livewireScriptConfig

</body>

</html>
