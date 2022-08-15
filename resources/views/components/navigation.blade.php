<header x-cloak x-data="{ menu_open: false, header_position: '{{ $header_position ?? 'fixed' }}', header_colour: '{{ $header_colour ?? 'light' }}' }" @menutoggled.window="menu_open = $event.detail"
    :class="{
        'fixed left-0 right-0 top-0': header_position == 'fixed',
        'relative z-10': header_position !== 'fixed',
        'transition  duration-200 text-white': header_colour == 'light' || menu_open,
        'transition  duration-200 text-black': header_colour !== 'light' && !menu_open,
        'z-10': menu_open
    
    }">

    <div class="flex flex-row items-center gap-3 px-5 py-3 2xl:py-6">

        <a class="relative z-20 rounded-full bg-yellow px-2 pt-1.5 pb-1 text-lg font-bold tracking-tighter text-black"
            href="/">HPPH</a>

        <a class="relative z-20 rounded py-1 px-2"
            :class="{{ Request::routeIs('programme') ? 'true' : 'false' }} && !menu_open ? 'bg-yellow text-black' : ''"
            href="{{ route('programme') }}">What’s on</a>

        <x-strand-menu>Strands &amp; seasons</x-strand-menu>

        @include('components.header-menu')
        <livewire:search />

        @include('spektrix-components.login-status')
        @include('spektrix-components.basket')

        @if (isset($header_colour) && $header_colour == 'light')
            <div
                class="t-0 pointer-events-none absolute left-0 right-0 -z-10 h-72 bg-gradient-to-b from-black to-transparent">
            </div>
        @endif

        <div class="flex flex-row gap-1">

            @if ($edit_link ?? null)
                <a class="rounded bg-white bg-opacity-25 px-4 py-2" href="{{ $edit_link }}">Edit</a>
            @endif

            @env('local')
            <x-login-link class="rounded bg-white bg-opacity-25 px-4 py-2" email="john@letsdance.agency"
                label="Dashboard" redirect-url="{{ route('nova.pages.home') }}" />
            @endenv
        </div>
    </div>
</header>
