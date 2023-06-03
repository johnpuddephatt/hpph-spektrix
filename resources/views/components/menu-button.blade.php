<div class="{{ $header_class ?? 'text-white' }}" :class="{ '!text-white': nav_open }">
    <button @click="$dispatch('navtoggled', !nav_open)" aria-label="Toggle menu"
        class="hover:text-yellow transition fixed top-3 right-2 z-40 rounded-full p-2"
        :class="scrolled ? 'max-lg:bg-black max-lg:text-white' : null">
        <x-icon-menu class="w-6 h-6 p-0.5" x-show="!nav_open" />
        <x-icon-plus class="w-6 h-6 rotate-45" x-show="nav_open" />
    </button>
</div>
