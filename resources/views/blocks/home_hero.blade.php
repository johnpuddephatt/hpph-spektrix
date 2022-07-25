<div class="relative mt-[calc(100vh-1rem)]"></div>

<div class="fixed inset-0 -z-10 h-[calc(100vh-1rem)] w-full overflow-hidden bg-black">
    <x-home-slider :events="$block->events" />
    <x-home-journal-slider :posts="$block->posts" />

    <div class="pointer-events-none absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-black to-transparent">
    </div>

    <div
        class="absolute top-1/2 left-1/2 h-64 w-96 -translate-x-1/2 -translate-y-1/2 transform rounded-full border-8 border-yellow">
    </div>

    <a href="#after-hero"
        class="fixed left-1/2 top-[calc(100vh-4rem-1rem)] z-20 -translate-x-1/2 transform text-5xl text-white">@svg('down-chevron', 'h-16 w-16')</a>

</div>

<div id="after-hero"></div>
