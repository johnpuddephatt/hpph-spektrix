@if ($settings['alert_enabled'] && $settings['alert_display_until'] > now())
    <a target="_blank" href="{{ $settings['alert_url'] }}"
        class="type-xs-mono fixed bottom-4 left-4 right-4 z-50 flex rounded-full bg-yellow py-1 pl-1 pr-4 text-black lg:bottom-8 lg:left-auto lg:w-full lg:max-w-xs">

        @svg('exclamation', 'inline-block rounded-full text-yellow bg-black p-1.5 mr-2 h-6 w-6')
        <div class="w-full overflow-hidden text-ellipsis whitespace-nowrap">
            <span class="ticker inline-block py-1">
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
            </span>
        </div>
    </a>
@endif
