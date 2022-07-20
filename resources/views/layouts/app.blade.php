<!DOCTYPE html>
<html class="scroll-smooth antialiased">

<head>

    @production
        @includeWhen(nova_get_setting('google_analytics'), 'analytics')
    @endproduction

    <title>
        {{ config('app.name') }} — @yield('title', config('app.description'))
    </title>
    <meta name="description" content="@yield('description', config('app.description'))" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="canonical" href="@yield('canonical', Request::url())" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script
        src="https://{{ nova_get_setting('spektrix_custom_domain') }}/{{ nova_get_setting('spektrix_client_name') }}/website/scripts/integrate.js">
    </script>
    <script src="https://webcomponents.spektrix.com/stable/webcomponents-loader.js"></script>
    <script src="https://webcomponents.spektrix.com/stable/spektrix-component-loader.js" data-components="@getWebComponents()"
        async></script>

    @livewireStyles

    @stack('head')
</head>

<body class="leading-[125%] tracking-[-0.015em]" :class="{ 'overflow-hidden': strands_open }" x-data="{ strands_open: false }"
    @strandmenutoggled.window="strands_open = $event.detail">
    @yield('content')
    @stack('footer')
    @livewireScripts
</body>

</html>
