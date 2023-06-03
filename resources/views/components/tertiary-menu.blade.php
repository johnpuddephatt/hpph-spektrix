@if ($tertiary_menu)
    <nav {{ $attributes }}>
        <ul class="space-y-1">
            @foreach ($tertiary_menu as $menu_item)
                <li class="leading-none">
                    <a class="!leading-tight inline-block font-mono uppercase text-[0.625rem] tracking-[-0.02em] antialiased text-gray-medium hover:text-yellow transition"
                        href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
