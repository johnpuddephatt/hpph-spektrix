<header x-cloak x-data="{ menu_open: false, header_position: '{{ $header_position ?? 'static' }}' }" @menutoggled.window="menu_open = $event.detail"
    :class="{
        'fixed left-0 right-0 top-0': header_position == 'fixed',
        'absolute left-0 right-0 top-0': header_position == 'absolute',
        'relative': header_position == 'static',
        'transition duration-200': header_position == 'absolute' || header_position == 'fixed' || menu_open,
        'transition duration-200': header_position == 'static' && !menu_open,
        '!text-white': menu_open || nav_open
    }"
    class="{{ $header_class ?? 'text-white' }} z-20">

    <div class="container flex flex-row items-center py-3 2xl:py-6">
        <a title="Navigate to homepage" aria-label="Navigate to homepage" class="relative z-20 mr-3 text-yellow"
            style="color: @yield('color')" href="/">
            @svg('logo-compact', 'h-10 w-auto ' . ($logo_background ?? 'text-transparent'))</a>

        <a class="type-xs-mono relative z-20 flex flex-row items-center gap-1.5 rounded py-1 px-2"
            :class="{
                'bg-yellow text-black': {{ Request::routeIs('programme') ? 'true' : 'false' }} && !menu_open,
                'max-lg:!hidden': scrolled
            }"
            href="{{ route('programme') }}">
            @svg('eye', 'block w-5 h-5 pb-0.5')
            What’s on</a>

        @env('local')
        <x-login-link class="type-xs-mono rounded bg-white bg-opacity-25 px-4 py-1.5 ml-2" email="john@letsdance.agency"
            label="Login" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv

        @include('sections.navigation')

        <div class="absolute top-14 lg:top-16 right-5 flex flex-col items-center lg:mt-0 gap-3">
            <livewire:search />
            @production
                @include('spektrix-components.basket')
                @include('spektrix-components.login-status')
            @endproduction

            @if ($edit_link ?? null)
                <a aria-label="Edit page" title="Edit page" class="inline-block" :class="{ 'max-lg:!hidden': scrolled }"
                    href="{{ $edit_link }}">@svg('edit', 'h-6 w-6 lg:h-8 lg:w-8 p-0.5 pb-0.5')</a>
            @endif
        </div>

        @if ($header_position == 'absolute')
            <div class="t-0 fade-to-bottom pointer-events-none absolute left-0 right-0 z-[-1] h-72">
            </div>
        @endif

    </div>

</header>
