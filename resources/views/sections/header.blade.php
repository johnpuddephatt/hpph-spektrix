<header x-cloak class="{{ $header_class ?? 'text-white' }} z-20 fixed left-0 right-0 top-0">
    <div class="container flex flex-row items-center py-3 2xl:py-6">
        <a title="Navigate to homepage" aria-label="Navigate to homepage" class="relative z-20 lg:-ml-2 mr-3 text-yellow"
            style="color: @yield('color')" href="/">
            @svg('logo-compact', 'h-[2.35rem] w-auto')</a>

        <a class="type-xs-mono hover:text-yellow transition relative z-20 flex flex-row items-center gap-1.5 rounded py-1 px-2"
            :class="{
                'bg-yellow !text-black': {{ '/' . Request::path() == \App\Models\Page::getTemplateUrl('programme-page') ? 'true' : 'false' }},
                'max-lg:!hidden': scrolled
            }"
            href="{{ \App\Models\Page::getTemplateUrl('programme-page') }}">
            @svg('eye', 'block w-5 h-5 pb-0.5')
            What’s on</a>

        @env('local')
        <x-login-link class="type-xs-mono rounded bg-white bg-opacity-25 px-4 py-1.5 ml-2" email="john@letsdance.agency"
            label="Login" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv

        <div class="hidden lg:block w-1/2 ml-auto">
            <div class="container">
                @yield('menu_right')
            </div>
        </div>

        <div x-trap="nav_open"
            class="absolute z-30 max-lg:z-40 top-12 right-4 flex flex-col items-center lg:mt-0 gap-2.5"
            :class="{
                '!text-white': nav_open,
            }">
            @include('components.menu-button')

            <livewire:search />

            @include('spektrix-components.basket')
            @include('spektrix-components.login-status')

            @if (\Auth::user() && isset($edit_link))
                <a aria-label="Edit page" title="Edit page" class="inline-block hover:text-yellow transition"
                    :class="{ 'max-lg:!hidden': scrolled && !nav_open }"
                    href="{{ $edit_link }}">@svg('edit', 'h-6 w-6 pb-0.5')</a>
            @endif

            @include('sections.navigation')
        </div>

    </div>

</header>
