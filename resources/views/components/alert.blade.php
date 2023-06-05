@if ($settings['alert_enabled'] && $settings['alert_display_until'] > now())
    <a href="{{ $settings['alert_url'] }}"
        class="type-xs-mono flex z-50 bg-yellow text-black lg:max-w-xs lg:w-full pl-1 rounded-full py-1 pr-4 absolute bottom-4 left-4 right-4 lg:bottom-8 lg:left-auto">

        @svg('exclamation', 'inline-block rounded-full text-yellow bg-black p-1.5 mr-2 h-6 w-6')
        <div class="w-full whitespace-nowrap text-ellipsis overflow-hidden">
            <span class="ticker py-1 inline-block">
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
                <span class="inline-block pr-8">{{ $settings['alert_message'] }}</span>
            </span>
        </div>
    </a>
@endif
