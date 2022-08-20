<header x-cloak x-data="{ menu_open: false, header_position: '{{ $header_position }}', header_colour: '{{ $header_colour }}' }" @menutoggled.window="menu_open = $event.detail"
    :class="{
        'z-10 lg:z-0 absolute lg:fixed left-0 right-0 top-0': header_position == 'fixed',
        'relative z-10': header_position != 'fixed',
        'transition duration-200 text-white': header_colour == 'light' || menu_open,
        'transition duration-200 text-black': header_colour != 'light' && !menu_open,
        'z-10': menu_open || nav_open
    }">

    <div class="flex flex-row items-center px-5 py-3 2xl:py-6">
        <a title="HPPH Home" aria-label="HPPH Home" class="relative z-20 mr-4 text-black" href="/">
            @svg('logo-compact', 'h-10 w-auto')</a>

        <a class="relative z-20 ml-auto mr-5 rounded py-1 px-2 lg:mr-2"
            :class="{{ Request::routeIs('programme') ? 'true' : 'false' }} && !menu_open ? 'bg-yellow text-black' : ''"
            href="{{ route('programme') }}">
            @svg('eye', 'inline-block w-6 h-6 pb-0.5')
            What’s on</a>


        @include('components.header-menu')

        @if ($header_colour == 'light')
            <div
                class="t-0 pointer-events-none absolute left-0 right-0 -z-10 h-72 bg-gradient-to-b from-black to-transparent">
            </div>
        @endif

        @env('local')
        <x-login-link class="fixed bottom-4 right-4 rounded bg-gray-light bg-opacity-25 px-4 py-2"
            email="john@letsdance.agency" label="Login" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv
    </div>

</header>
