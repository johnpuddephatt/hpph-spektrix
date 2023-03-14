@props(['hide_marquee' => false])

@if (isset($settings['banner_enabled']) && !$hide_marquee)
    <a style="background-color: @yield('color')" href="{{ $settings['banner_url'] }}"
        {{ $attributes->class(['relative bg-yellow block whitespace-nowrap w-screen overflow-hidden']) }}">
        <div class="marquee py-10 inline-flex flex-row items-center gap-3" x-init="animationDuration = $el.clientWidth * 10" x-data="{ animationDuration: 10000 }"
            x-bind:style="`animation-duration: ${animationDuration}ms;`">
            @foreach ([1, 2, 3, 4] as $loop)
                @svg('plus', 'block h-6 w-6')
                <div class="type-xs-mono inline-block bg-black text-yellow py-0.5 px-2 rounded-full">New!
                </div>
                <div class="type-regular !font-normal !leading-none inline-block">
                    @foreach ($settings['banner_values'] as $value)
                        <span class="{{ $value['bold?'] ? 'font-bold' : '' }} inline-block">
                            {{ $value['label'] }}

                        </span>
                        @if (!$loop->last)
                            &nbsp;&bullet;&nbsp;
                        @else
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </a>
@endif
