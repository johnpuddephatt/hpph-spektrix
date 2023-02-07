<div class="{{ $header_class ?? 'text-white' }}">
    <button @click="$dispatch('navtoggled', !nav_open)" aria-label="Toggle menu"
        class="fixed top-3 right-3 z-40 rounded-full p-2" :class="scrolled ? 'max-lg:bg-black max-lg:text-white' : null">
        <x-icon-menu class="h-8 w-8 p-0.5" x-show="!nav_open" />
        <x-icon-plus class="h-8 w-8 p-0.5 rotate-45" x-show="nav_open" />
    </button>
</div>
