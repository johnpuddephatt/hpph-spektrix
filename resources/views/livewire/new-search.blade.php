<div @keyup.escape.window="open = false" class="" x-data="{ open: false }">
    <button aria-label="Search for a film" title="Search for a film"
        class="hover:text-yellow transition relative block rounded" :class="{ 'max-lg:hidden': scrolled && !nav_open }"
        @click="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('search', 'w-6 h-6 p-0.5')</button>

    {{-- <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-20 bg-black bg-opacity-60 duration-150 backdrop-blur-lg">

    </div> --}}
    <div x-trap="open"
        class="flex bg-sand text-black fixed overscroll-contain inset-0 z-50 left-auto flex-col w-full transform transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <div
            class="{{ strlen($search) > 2 ? 'h-[33vh]' : 'h-screen' }} duration-200 flex-col flex bg-yellow transform transition-all ease-linear container px-4 py-8">
            <div class="relative"> <button class="top-7 absolute z-50 right-0 ml-auto"
                    @click="open = ! open; $dispatch('menutoggled', open)"
                    aria-label="Close search menu">@svg('plus', 'h-6 w-6 transform rotate-45 origin-center text-black')</button></div>
            <div class="text-center my-auto relative">

                <h2 class="type-xs-mono">Search for a film below</h2>
                <input x-ref="searchInput"
                    class="type-medium lg:type-xl max-w-2xl text-center block placeholder:text-black placeholder:text-opacity-30 mx-auto w-full bg-transparent py-6 focus-visible:outline-none"
                    wire:model="search" type="text" placeholder=" &thinsp;Type here&hellip;" />

            </div>
        </div>
        <div
            class="{{ strlen($search) > 2 ? 'h-[67vh] flex-1 ' : 'h-0 overflow-hidden ' }} bg-sand flex flex-col transition-all ease-linear duration-200">
            <div class="type-xs-mono bg-sand-light container py-2">Results [{{ count($results) }}]</div>
            @if (count($results))
                <ul class="overflow-y-auto md:container md:divide-y md:divide-sand-dark">
                    @foreach ($results as $result)
                        <x-event-row :event="$result" />
                    @endforeach
                </ul>
            @else
                <div class="type-xs-mono py-36 container text-center">No results found</div>
            @endif
        </div>

    </div>
</div>
