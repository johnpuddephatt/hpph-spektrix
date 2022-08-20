@webComponent('spektrix-basket-summary')

<spektrix-basket-summary hidden id="spektrixBasketSummary" class="" x-data="{ open: false, iFrameLoading: true }"
    x-effect="if(open == false) { iFrameLoading = true; }" client-name="{{ nova_get_setting('spektrix_client_name') }}"
    custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}">
    <a href="/basket/" class="relative block" :class="open ? 'bg-yellow text-black z-40' : ''"
        @click.prevent="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
        @svg('basket', 'h-10 w-10 lg:h-6 lg:w-6 pb-1 ')
        <span
            class="mobile-basket-count absolute top-0 right-0 translate-x-1/2 -translate-y-1/4 transform rounded-full bg-yellow px-0.5 text-[0.65rem] leading-tight text-black"
            data-basket-item-count></span>
    </a>
    <script>
        // Add 'hidden' attribute to <spektrix-basket-summary> to enable hidding empty basket.
        let showBasketIfNotEmpty = function() {
            var spektrixBasketSummary = document.getElementById(
                'spektrixBasketSummary'
            );
            if (spektrixBasketSummary.getAttribute('count') > 0) {
                spektrixBasketSummary.removeAttribute('hidden');
                spektrixBasketSummary.classList.add('block');
            }
        };
        showBasketIfNotEmpty();
        setInterval(() => {
            showBasketIfNotEmpty();
        }, 1000);
    </script>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-80 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-20 flex h-screen w-full max-w-lg transform flex-col bg-sand p-12 transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <template x-if="open">
            <div>
                <div x-show="iFrameLoading" x-transition class="absolute inset-0 p-16">
                    @svg('loading', 'w-32 mx-auto block pt-24 text-gray-medium')
                </div>
                <iframe x-on:load="iFrameLoading = false" class="w-full transition-all"
                    :class="{ 'opacity-0': iFrameLoading }" id="SpektrixIFrame" name="SpektrixIFrame"
                    :src="`https://{{ nova_get_setting('spektrix_custom_domain') }}/{{ nova_get_setting('spektrix_client_name') }}/website/Basket2.aspx?resize=true`"></iframe>
            </div>
        </template>

    </div>
</spektrix-basket-summary>

<!-- </div> -->
