<div class="mt-[calc(150vh-1rem)] hidden w-screen overflow-hidden lg:mt-[calc(100vh-1rem)] lg:block"></div>

<div class="relative inset-0 w-full overflow-hidden bg-black lg:fixed lg:-z-10 lg:h-[calc(100vh-1rem)]">

    <x-home-hero-events :events="$page->content->events" />
    <x-home-hero-journal :posts="$page->content->posts" />

    <div class="pointer-events-none absolute bottom-0 left-0 right-0 h-96 bg-gradient-to-t from-black to-transparent">
    </div>

    @svg('logo-full', 'max-w-[80vw]  lg:px-0` w-96 absolute top-[50vh] left-1/2 -translate-x-1/2 -translate-y-1/2 transform text-yellow')

    <a href="#after-hero"
        class="fixed left-1/2 top-[calc(100vh-4rem-1rem)] z-20 hidden -translate-x-1/2 transform text-5xl text-white lg:block">@svg('down-chevron', 'h-16 w-16')</a>

</div>

<div id="after-hero"></div>
