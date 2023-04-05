<div class="mt-[100vh] block w-screen overflow-hidden">
</div>

<div class="fixed inset-0 -z-10 h-screen w-full overflow-hidden border-b-[1rem] border-yellow bg-black">
    <x-home-hero-events :events="$page->content->events" />
    <div :class="scrolled ? 'opacity-0 -translate-y-8 lg:opacity-100 lg:translate-y-0' : ''"
        class="absolute inset-0 transform transition">
        @svg('logo-full', 'max-w-[80vw]  lg:px-0 w-72 lg:w-96 absolute top-[50vh] left-1/2 -translate-x-1/2 -translate-y-1/2 transform text-yellow')
        <button @click="document.documentElement.scrollTop = 12"
            class="fixed left-1/2 bottom-16 z-20 -translate-x-1/2 transform rounded-full bg-black p-4 text-5xl text-white lg:hidden">@svg('arrow-right', 'transform rotate-90 h-6 w-6')</button>
    </div>
</div>
