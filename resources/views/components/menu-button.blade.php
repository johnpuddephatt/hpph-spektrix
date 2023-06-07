<div class="{{ $header_class ?? 'text-white' }}">
    <button @click="$dispatch('navtoggled', true)" aria-label="Open menu"
        class="hover:text-yellow transition fixed top-3 right-2 z-20 rounded-full p-2"
        :class="scrolled ? 'max-lg:bg-black max-lg:text-white' : null">
        <x-icon-menu class="w-6 h-6 p-0.5" />
    </button>
</div>
