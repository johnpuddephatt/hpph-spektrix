<header x-cloak
    class="{{ $header_class ?? 'text-white' }} {{ $settings['alert_enabled'] && $settings['alert_display_until'] > now() ? 'top-8 lg:top-0' : 'top-0' }} fixed left-0 right-0 z-20">
    <div class="container flex flex-row items-center py-3">
        <a title="Navigate to homepage" aria-label="Navigate to homepage" class="relative z-20 mr-3 text-yellow lg:-ml-2"
            style="color: @yield('color')" href="/">
            @svg('logo-compact', 'h-[2.35rem] w-auto')</a>

        <a class="type-xs-mono relative z-20 flex flex-row items-center gap-1.5 rounded px-2 py-1 transition hover:text-yellow"
            :class="{
                'bg-yellow !text-black': {{ '/' . Request::path() == $programme_page_url ? 'true' : 'false' }},
                'max-lg:!hidden': scrolled
            }"
            href="{{ $programme_page_url }}">
            @svg('eye', 'block w-5 h-5 pb-0.5')
            What’s on</a>

        @env('local')
            <x-login-link class="type-xs-mono ml-2 rounded bg-white bg-opacity-25 px-4 py-1.5" email="john@letsdance.agency"
                label="Login" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv

        <div class="ml-auto hidden w-1/2 lg:block">
            <div class="container">
                @yield('menu_right')
            </div>
        </div>

        <div x-trap="nav_open" class="absolute right-4 top-12 z-30 flex flex-col items-center gap-3 max-lg:z-40 lg:mt-0"
            :class="{
                '!text-white': nav_open,
            }">
            @include('components.menu-button')

            <livewire:new-search />

            @include('spektrix-components.basket')
            @include('spektrix-components.login-status')

            @if (\Auth::user() && isset($edit_link))
                <!-- !hidden should be max-lg:!hidden if we don't want the edit link to hide on desktop -->
                <a aria-label="Edit page" title="Edit page" class="inline-block transition hover:text-yellow"
                    :class="{ '!hidden': scrolled && !nav_open }" href="{{ $edit_link }}">@svg('edit', 'h-6 w-6 pb-0.5')</a>
            @endif

            @include('sections.navigation')
        </div>

    </div>

</header>
