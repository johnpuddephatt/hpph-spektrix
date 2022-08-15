@if ($header_menu)
    <nav>
        <ul class="flex flex-row gap-6">
            @foreach ($header_menu as $menu_item)
                <li>
                    <a href="{{ $menu_item['value'] }}">{{ $menu_item['name'] }}</a>
                </li>
                @foreach ($menu_item['children'] as $child_menu_item)
                    <li>
                        <a href="{{ $child_menu_item['value'] }}">
                            ––– {{ $child_menu_item['name'] }}
                        </a>
                    </li>
                @endforeach
                </li>
            @endforeach
        </ul>
    </nav>
@endif
