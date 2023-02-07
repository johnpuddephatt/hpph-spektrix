<!DOCTYPE html>
<html class="scroll-smooth antialiased 2xl:text-lg">

<head>

    @production
        @includeWhen(isset($settings['google_analytics']), 'analytics')
    @endproduction

    <title>
        @yield('title', config('app.description')) | {{ config('app.name') }}
    </title>
    <meta name="description" content="@yield('description', config('app.description'))" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="@yield('canonical', Request::url())" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script
        src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/scripts/integrate.js">
    </script>
    <script src="https://webcomponents.spektrix.com/stable/webcomponents-loader.js"></script>
    <script src="https://webcomponents.spektrix.com/stable/spektrix-component-loader.js"
        data-components="{{ trim(implode(',', explode('#', $__env->yieldPushContent('webComponents'))), ',') }}" async>
    </script>

    @livewireStyles
    @stack('head')
</head>

<body class="text-[0.875rem] lg:text-[1rem] leading-[157.1%] lg:leading-[162.5%] tracking-normal"
    :class="{ 'overflow-hidden': menu_open || nav_open }" x-data="{ scrolled: false, menu_open: false, nav_open: false }"
    @menutoggled.window="menu_open = $event.detail" @navtoggled.window="nav_open = $event.detail"
    @scrolled.window="scrolled =  $event.detail;">
    @yield('templatecontent')
    @stack('footer')
    @livewireScripts
</body>

</html>
