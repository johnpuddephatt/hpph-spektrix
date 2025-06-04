@push('webComponents', '#spektrix-basket-summary')

<spektrix-basket-summary id="spektrixBasketSummary" class="relative" x-data="{ open: false, iFrameLoading: true }"
    x-effect="if(open == false) { iFrameLoading = true; }" client-name="{{ $settings['spektrix_client_name'] }}"
    custom-domain="{{ $settings['spektrix_custom_domain'] }}">
    <button aria-label="View basket" class="hover:text-yellow transition cursor-pointer relative block"
        :class="{ 'max-lg:hidden': scrolled && !nav_open }"
        @click.prevent="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('basket', 'h-6 w-6 pb-0.5 ')

    </button>
    <span hidden id="spektrixBasketCount"
        :class="{ 'max-lg:!fixed max-lg:!top-3 max-lg:!right-3 max-lg:z-40 ': scrolled && !nav_open }"
        class="mobile-basket-count absolute top-0 right-0 h-4 translate-x-1/2 -translate-y-1/4 transform rounded-full bg-yellow-dark px-1.5 pt-0.5 text-center text-[0.65rem] leading-tight text-black"
        data-basket-item-count></span>
    <script>
        // Add 'hidden' attribute to <spektrix-basket-summary> to enable hidding empty basket.
        let showBasketCountIfNotEmpty = function() {
            var spektrixBasketCount = document.getElementById(
                'spektrixBasketCount'
            );
            if (spektrixBasketSummary.getAttribute('count') > 0) {
                spektrixBasketCount.removeAttribute('hidden');
                spektrixBasketCount.classList.add('block');
            }
        };
        showBasketCountIfNotEmpty();
        setInterval(() => {
            showBasketCountIfNotEmpty();
        }, 1000);
    </script>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 bg-black backdrop-blur-lg bg-opacity-60 duration-150"
        x-transition:enter-start="opacity-0" x-transition:leave-end="opacity-0">
    </div>
    <div class="container fixed inset-0 left-auto z-50 overflow-y-auto flex h-screen w-full max-w-lg transform flex-col bg-sand p-12 transition-all delay-100 duration-200"
        x-trap="open" x-show="open" x-transition:enter-start="translate-x-full"
        x-transition:leave-end="translate-x-full">
        <template x-if="open">
            <div class="relative">
                <button class="absolute right-0 top-0 z-10 ml-auto"
                    @click="open = ! open; $dispatch('menutoggled', open)"
                    aria-label="Close basket menu">@svg('plus', 'h-6 w-6 transform rotate-45 origin-center text-black')</button>
                <div x-show="iFrameLoading" x-transition class="absolute inset-0 p-16">
                    @svg('loading', 'w-32 mx-auto block pt-24 text-sand-dark')
                </div>
                <iframe x-on:load="iFrameLoading = false" class="w-full transition-all"
                    :class="{ 'opacity-0': iFrameLoading }" id="SpektrixIFrame" name="SpektrixIFrame"
                    :src="`https://{{ $settings['spektrix_custom_domain'] }}/{{ $settings['spektrix_client_name'] }}/website/Basket2.aspx?resize=true&stylesheet=hpph-spektrix-2.css`"></iframe>
            </div>
        </template>

    </div>
</spektrix-basket-summary>
