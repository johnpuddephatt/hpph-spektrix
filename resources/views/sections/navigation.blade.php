<div class="flex flex-col lg:flex-row fixed inset-0 z-30 h-screen transform overflow-y-auto bg-black text-white transition-transform"
    :class="nav_open ? 'translate-x-0' : 'translate-x-full'" @keyup.escape.window="nav_open = false">
    <div class="lg:w-4/12 py-8 px-6 lg:px-12 flex flex-col flex-grow">
        @if ($primary_menu)
            <nav class="mb-24">
                <ul class="text-[3.75rem] font-bold leading-[108%] tracking-[-0.050em] text-white">
                    <li>
                        <a href="/" class="relative block py-0.5 hover:text-yellow transition">
                            @if (Request::is('/'))
                                <span
                                    class="-left-4 absolute top-1/2 transform -translate-y-full block w-3 h-3 rounded-full bg-yellow"></span>
                            @endif
                            Home
                        </a>
                    </li>
                    @foreach ($primary_menu as $menu_item)
                        <li>
                            <a href="{{ $menu_item['value'] }}"
                                class="relative block py-0.5 hover:text-yellow transition">
                                @if (Str::of($menu_item['value'])->startsWith('/' . Request::path()))
                                    <span
                                        class="-left-4 absolute top-1/2 transform -translate-y-full block w-3 h-3 rounded-full bg-yellow"></span>
                                @endif
                                {{ $menu_item['name'] }}

                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($seasons->count())
            <div class="flex flex-col gap-4">
                @foreach ($seasons as $season)
                    <a href="{{ $season->url }}"
                        class="truncate max-w-full float-left mr-auto clear-both border border-yellow rounded py-1.5 pl-1 pr-2">
                        @if ($loop->first)
                            <span
                                class="type-xs-mono !leading-none bg-yellow text-black py-1.5 rounded-full px-2 inline-block align-top mr-1">New!</span>
                        @endif
                        <span class="font-bold text-yellow uppercase">{{ $season->name }}</span>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="hidden lg:flex mt-auto mb-8 flex-row gap-3 py-1 pt-8 lg:w-1/2 justify-start xl:items-start">
            @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                <x-social-icon :account="$account" />
            @endforeach
        </div>

        <x-credits class="hidden lg:block" />

    </div>

    <div class="flex flex-col py-8 px-6 lg:px-12 lg:w-3/12">

        @if ($secondary_menu)
            <nav>
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

        <div class="lg:hidden flex mt-auto mb-8 flex-row gap-3 py-1">
            @foreach (['facebook', 'twitter', 'youtube', 'instagram', 'linkedin', 'vimeo'] as $account)
                <x-social-icon :account="$account" />
            @endforeach
        </div>

        <x-tertiary-menu class="mt-auto hidden lg:block" />

    </div>

    <div class="px-6 py-8 lg:hidden grid grid-cols-2 gap-4">
        <x-tertiary-menu />
        <x-credits />
    </div>

    <x-strand-menu>Programme strands @svg('arrow-right', 'inline-block ml-auto w-10 h-10 p-2.5 bg-black rounded-full text-yellow')</x-strand-menu>

</div>
