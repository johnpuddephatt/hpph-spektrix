<div x-data="{}" class="lg:flex-grow">

    <div class="fixed inset-0 z-40 h-screen transform overflow-y-auto bg-yellow text-black transition-transform lg:static lg:h-auto lg:translate-x-0 lg:transform-none lg:bg-transparent lg:text-current"
        :class="nav_open ? 'translate-x-0' : 'translate-x-full'">
        <nav
            class="lg:text-inherit type-h5 flex min-h-screen flex-col items-center justify-center gap-3 font-bold lg:min-h-0 lg:flex-row lg:text-base lg:font-normal lg:tracking-normal">

            <x-strand-menu>Strands &amp; seasons</x-strand-menu>
            @if ($header_menu)
                <ul class="flex flex-col gap-3 text-center lg:flex-row lg:gap-6 lg:text-left">
                    @foreach ($header_menu as $menu_item)
                        <li>
                            <a href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                        </li>
                        <!-- @foreach ($menu_item['children'] as $child_menu_item)
<li>
                        <a href="{{ $child_menu_item['value'] }}">
                            ––– {{ $child_menu_item['name'] }}
                        </a>
                    </li>
@endforeach -->
                        </li>
                    @endforeach
                </ul>
            @endif
            <div class="mt-8 flex flex-row items-center gap-6 lg:mt-0 lg:gap-3">
                <livewire:search />
                @include('spektrix-components.login-status')
                @include('spektrix-components.basket')
                @if ($edit_link ?? null)
                    <a title="Edit page" class="inline-block" href="{{ $edit_link }}">@svg('edit', 'h-10 w-10 lg:h-6 lg:w-6 p-0.5 pb-0.5')</a>
                @endif
            </div>

        </nav>
        <div class="lg:hidden">
            @include('sections.footer')
        </div>
    </div>

</div>
