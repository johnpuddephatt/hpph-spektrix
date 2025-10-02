@if ($settings['alert_enabled'] && $settings['alert_display_until'] > now())
    <a target="_blank" href="{{ $settings['alert_url'] }}"
        class="type-xs-mono fixed left-0 right-0 top-0 z-30 flex bg-yellow py-1 pl-1 text-black shadow lg:fixed lg:left-auto lg:right-16 lg:top-4 lg:w-full lg:max-w-xs lg:rounded-full">

        @svg('exclamation', 'inline-block rounded-full text-yellow bg-black p-1.5 mr-2 h-6 w-6')
        <div class="w-full overflow-hidden text-ellipsis whitespace-nowrap">
            <span class="ticker inline-block py-1">
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
            </span>
        </div>
    </a>
@endif
