<!DOCTYPE html>
<html class="scroll-smooth antialiased">
<!-- 2xl:text-lg -->

<head>

    @production
        @includeWhen(isset($settings['google_analytics']), 'analytics')
    @endproduction

    <title>@yield('title', config('app.description'))</title>
    <meta name="description" content="@yield('description', config('app.description'))" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="@yield('canonical', Request::url())" />

    <link rel="shortcut icon" type="image/png" href="/favicon.png" />

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

    @if ($settings['google_analytics'])
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', "{{ $settings['google_analytics'] }}");
        </script>
    @endif

    @livewireStyles
    @stack('head')
</head>

<body class="leading-[162.5%] tracking-normal"
    :class="{ 'overflow-hidden': menu_open || nav_open || booking_path_open }" x-data="{ scrolled: false, menu_open: false, nav_open: false, booking_path_open: false }"
    @menutoggled.window="menu_open = $event.detail" @navtoggled.window="nav_open = $event.detail"
    @booking.window="booking_path_open = $event.detail" @scrolled.window="scrolled =  $event.detail;">
    @yield('templatecontent')
    @livewireScripts
    @stack('footer')

</body>

</html>
