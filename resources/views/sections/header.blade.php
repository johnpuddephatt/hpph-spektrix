<header x-cloak x-data="{ menu_open: false }" @menutoggled.window="menu_open = $event.detail"
    :class="{
        'transition duration-200 !z-30 !text-white': menu_open,
    }"
    class="{{ $header_class ?? 'text-white' }} z-20 fixed left-0 right-0 top-0">
    <div class="container flex flex-row items-center py-3 2xl:py-6">
        <a title="Navigate to homepage" aria-label="Navigate to homepage" class="relative z-20 lg:-ml-2 mr-3 text-yellow"
            style="color: @yield('color')" href="/">
            @svg('logo-compact', 'h-[2.35rem] w-auto')</a>

        <a class="type-xs-mono hover:text-yellow transition relative z-20 flex flex-row items-center gap-1.5 rounded py-1 px-2"
            :class="{
                'bg-yellow !text-black': {{ Request::routeIs('programme') ? 'true' : 'false' }} && !menu_open,
                'max-lg:!hidden': scrolled
            }"
            href="{{ route('programme') }}">
            @svg('eye', 'block w-5 h-5 pb-0.5')
            What’s on</a>

        @env('local')
        <x-login-link class="type-xs-mono rounded bg-white bg-opacity-25 px-4 py-1.5 ml-2" email="john@letsdance.agency"
            label="Login" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv

        <div class="hidden w-1/2 ml-auto">
            <div class="container">
                @yield('menu_right')
            </div>
        </div>

        @include('sections.navigation')

        <div class="absolute max-lg:z-40 top-12 right-4 flex flex-col items-center lg:mt-0 gap-2.5">
            @include('components.menu-button')

            <livewire:search />

            @include('spektrix-components.basket')
            @include('spektrix-components.login-status')

            @if (\Auth::user() && isset($edit_link))
                <a aria-label="Edit page" title="Edit page" class="inline-block hover:text-yellow transition"
                    :class="{ 'max-lg:!hidden': scrolled && !nav_open }"
                    href="{{ $edit_link }}">@svg('edit', 'h-6 w-6 pb-0.5')</a>
            @endif
        </div>

    </div>

</header>
