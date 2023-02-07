@if (isset($settings['banner_enabled']))

    <a style="background-color: @yield('color')" href="{{ $settings['banner_url'] }}"
        class="bg-yellow py-10 text-lg text-black block whitespace-nowrap w-screen overflow-hidden">
        <div class="flex flex-row w-[500vw]">
            <div class="marquee type-regular !font-normal">
                @foreach (array_merge($settings['banner_values'], $settings['banner_values'], $settings['banner_values'], $settings['banner_values'], $settings['banner_values'], $settings['banner_values'], $settings['banner_values'], $settings['banner_values']) as $value)
                    <span class="inline-block">{{ $value['label'] }}
                        &nbsp;&bullet;&nbsp;
                    </span>
                @endforeach
            </div>
        </div>
    </a>
@endif
