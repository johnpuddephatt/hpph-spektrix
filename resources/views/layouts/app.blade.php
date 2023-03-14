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

    @if ($__env->yieldPushContent('webComponents'))
        <script
            src="https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/scripts/integrate.js">
        </script>

        <script src="https://webcomponents.spektrix.com/stable/webcomponents-loader.js"></script>
        <script src="https://webcomponents.spektrix.com/stable/spektrix-component-loader.js"
            data-components="{{ trim(implode(',', explode('#', $__env->yieldPushContent('webComponents'))), ',') }}" async>
        </script>
    @endif

    @livewireStyles
    @stack('head')
</head>

<body class="leading-[162.5%] tracking-normal" :class="{ 'overflow-hidden': menu_open || nav_open || booking_path_open }"
    x-data="{ scrolled: false, menu_open: false, nav_open: false, booking_path_open: false }" @menutoggled.window="menu_open = $event.detail" @navtoggled.window="nav_open = $event.detail"
    @booking.window="booking_path_open = $event.detail" @scrolled.window="scrolled =  $event.detail;">
    @yield('templatecontent')
    @stack('footer')
    @livewireScripts

    {{-- @env('local')
    <div
        class="border-gray-light bg-gray-light text-black flex items-center m-2 fixed bottom-0 right-0 border rounded p-2 text-sm">

        Breakpoint:
        <span class="ml-1 sm:hidden md:hidden lg:hidden xl:hidden">&lt;640px</span>
        <span class="ml-1 hidden sm:inline md:hidden font-extrabold">sm</span>
        <span class="ml-1 hidden md:inline lg:hidden font-extrabold">md</span>
        <span class="ml-1 hidden lg:inline xl:hidden font-extrabold">lg</span>
        <span class="ml-1 hidden xl:inline 2xl:hidden font-extrabold">xl</span>
        <span class="ml-1 hidden 2xl:inline font-extrabold">2xl</span>
    </div>
    @endenv --}}
</body>

</html>
