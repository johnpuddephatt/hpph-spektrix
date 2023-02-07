<header x-cloak x-data="{ menu_open: false, header_position: '{{ $header_position ?? 'static' }}' }" @menutoggled.window="menu_open = $event.detail"
    :class="{
        'z-10 fixed left-0 right-0 top-0': header_position == 'fixed',
        'z-10 lg:z-10 absolute left-0 right-0 top-0': header_position == 'absolute',
        'relative z-10': header_position == 'relative',
        'transition duration-200': header_position == 'absolute' || header_position == 'fixed' || menu_open,
        'relative z-10 transition duration-200': header_position == 'static' && !menu_open,
        'z-10': menu_open || nav_open
    }"
    class="{{ $header_class ?? 'text-white' }}">

    <div class="container flex flex-row items-center py-3 2xl:py-6">
        <a title="Navigate to homepage" aria-label="Navigate to homepage" class="relative z-20 mr-4 text-yellow"
            style="color: @yield('color')" href="/">
            @svg('logo-compact', 'h-10 w-auto')</a>

        <a class="type-xs-mono relative z-20 rounded py-1 px-2"
            :class="{
                'bg-yellow text-black': {{ Request::routeIs('programme') ? 'true' : 'false' }} && !menu_open,
                'max-lg:!hidden': scrolled
            }"
            href="{{ route('programme') }}">
            @svg('eye', 'inline-block w-6 h-6 pb-0.5')
            What’s on</a>

        @include('sections.navigation')

        <div class="absolute top-16 right-5 flex flex-col items-center gap-6 lg:mt-0 lg:gap-3">
            <livewire:search />
            @include('spektrix-components.basket')
            @include('spektrix-components.login-status')
            @if ($edit_link ?? null)
                <a aria-label="Edit page" title="Edit page" class="inline-block" :class="{ 'max-lg:!hidden': scrolled }"
                    href="{{ $edit_link }}">@svg('edit', 'h-8 w-8 p-0.5 pb-0.5')</a>
            @endif
        </div>

        @if ($header_position == 'absolute')
            <div class="t-0 fade-to-bottom pointer-events-none absolute left-0 right-0 z-[-1] h-72">
            </div>
        @endif

    </div>

</header>
