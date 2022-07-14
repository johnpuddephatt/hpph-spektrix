<header
    class="{{ isset($header_colour) && $header_colour == 'light' ? 'text-white' : 'text-black' }} {{ isset($header_position) && $header_position == 'fixed' ? 'fixed  -z-10 left-0 right-0 top-0' : 'relative z-10' }}">
    <div class="container flex flex-row items-center gap-6 py-4">

        <a class="rounded-full bg-yellow px-2 pt-0.5 text-lg font-bold tracking-tighter text-black"
            href="/">HPPH</a>

        <a class="" href="{{ route('programme') }}">What’s on</a>


        @include('components.header-menu')
        <livewire:search />

        @production
            @include('spektrix-components.login-status')
            @include('spektrix-components.basket')
        @endproduction

        @if (isset($header_colour) && $header_colour == 'light')
            <div
                class="t-0 to-transparent pointer-events-none absolute left-0 right-0 -z-10 h-72 bg-gradient-to-b from-black">
            </div>
        @endif



        @if ($edit_link ?? null)
            <a class="rounded bg-white bg-opacity-25 px-4 py-2" href="{{ $edit_link }}">Edit</a>
        @endif

        @env('local')
        <x-login-link class="-ml-4 rounded bg-white bg-opacity-25 px-4 py-2" email="john@letsdance.agency"
            label="Dashboard" redirect-url="{{ route('nova.pages.home') }}" />
        @endenv
    </div>
</header>
