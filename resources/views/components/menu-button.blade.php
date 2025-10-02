<div class="{{ $header_class ?? 'text-white' }}" :class="{ '!text-white': nav_open }">
    <button @click="$dispatch('navtoggled', !nav_open)" aria-label="Toggle menu"
        class="{{ $settings['alert_enabled'] && $settings['alert_display_until'] > now() ? 'top-11 lg:top-3' : 'top-3' }} fixed right-2 z-40 rounded-full p-2 transition hover:text-yellow"
        :class="scrolled ? 'max-lg:bg-black max-lg:text-white' : null">
        <x-icon-menu class="h-6 w-6 p-0.5" x-show="!nav_open" />
        <x-icon-plus class="h-6 w-6 rotate-45" x-show="nav_open" />
    </button>
</div>
