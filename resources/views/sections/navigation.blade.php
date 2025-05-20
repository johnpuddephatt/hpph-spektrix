<nav class="h-dynamic-screen flex flex-col md:flex-row fixed inset-0 -z-10 transform overflow-y-auto bg-black text-white transition-transform"
    x-show="nav_open" x-transition:enter="transition " x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full" @keyup.escape.window="nav_open = false">

    <div class="h-screen overflow-y-auto  md:w-1/2 lg:w-4/12 py-8 px-6 lg:px-12 flex flex-col flex-grow">
        @if ($primary_menu)
            <nav class="mb-8 lg:mb-24">
                <ul class="text-[3.75rem] font-bold leading-[108%] tracking-[-0.050em] text-white">
                    <li>
                        <a href="/" class="relative inline-block py-0.5 hover:text-yellow transition">
                            Home
                        </a>
                    </li>
                    @foreach ($primary_menu as $menu_item)
                        <li>
                            <a href="{{ $menu_item['value'] }}"
                                class="relative inline-block py-0.5 hover:text-yellow transition">
                                {{-- @if (Str::of($menu_item['value'])->startsWith('/' . Request::path()))
                                    <span
                                        class="-left-4 absolute top-1/2 transform -translate-y-full block w-3 h-3 rounded-full bg-yellow"></span>
                                @endif --}}
                                {{ $menu_item['name'] }}

                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($secondary_menu)
            <nav class="lg:hidden mb-24">
                <ul class="">
                    @foreach ($secondary_menu as $menu_item)
                        <li>
                            <a class="type-xs-mono antialiased text-gray-medium hover:text-white transition"
                                href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($seasons->count())
            <div class="flex flex-col gap-4">
                @foreach ($seasons as $season)
                    <a href="{{ $season->url }}"
                        class="truncate max-w-full float-left mr-auto text-yellow clear-both border border-yellow rounded py-1.5 pl-1 pr-2">
                        @if ($loop->first)
                            <span
                                class="type-xs-mono !leading-none bg-yellow text-black py-1.5 rounded-full px-2 inline-block align-top mr-1">New!</span>
                        @endif
                        <span class="font-bold uppercase">{{ $season->name }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="flex mt-auto mb-8 flex-row gap-3 py-1 pt-8 lg:w-1/2 justify-start xl:items-start">
            @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                <x-social-icon :account="$account" />
            @endforeach
        </div>

        <x-credits class="hidden md:block" />

        <!-- Middle column on desktop -->
        <div class="py-8 md:hidden grid grid-cols-2 gap-4">
            <x-tertiary-menu :tertiary_menu="$tertiary_menu" />
            <x-credits />
        </div>
    </div>

    <div class="hidden lg:flex flex-col py-8 lg:py-12  lg:px-12  lg:w-1/4">

        @if ($secondary_menu)
            <nav>
                <ul class="">
                    @foreach ($secondary_menu as $menu_item)
                        <li>
                            <a class="type-mono antialiased inline-block text-white hover:text-yellow transition py-2"
                                href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        <x-tertiary-menu :tertiary_menu="$tertiary_menu" class="mt-auto" />

    </div>

    <x-strand.menu>Programme strands @svg('arrow-right', 'inline-block ml-auto w-10 h-10 p-2.5 bg-black rounded-full text-yellow')</x-strand.menu>

</nav>
