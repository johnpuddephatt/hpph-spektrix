<div class="" x-data="{ open: false, iFrameLoading: true }" x-effect="if(open == false) { iFrameLoading = true; }">
    <a href="/basket/" class="relative block" :class="open ? 'bg-yellow text-black' : ''"
        @click.prevent="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        Quick book
    </a>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-80 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-20 flex h-screen w-full max-w-lg transform flex-col bg-sand p-12 transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <template x-if="open">
            <div class="relative">
                <button class="absolute right-0 top-0 z-10 ml-auto"
                    @click="open = ! open; $dispatch('menutoggled', open)"
                    aria-label="Close quick book menu">@svg('plus', 'h-8 w-8 transform rotate-45 origin-center text-gray-medium')</button>
                <div x-show="iFrameLoading" x-transition class="absolute inset-0 p-16">
                    @svg('loading', 'w-32 mx-auto block pt-24 text-sand-dark')
                </div>

                <iframe x-on:load="iFrameLoading = false" class="h-screen w-full overflow-x-auto transition-all"
                    :class="{ 'opacity-0': iFrameLoading }" id="SpektrixIFrame" name="SpektrixIFrame"
                    :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/ChooseSeats.aspx?EventInstanceId={{ substr($EventInstanceId, 0, 5) }}&resize=true`"></iframe>
            </div>
        </template>

    </div>
</div>
