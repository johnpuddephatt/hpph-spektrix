@webComponent('spektrix-basket-summary')




<div class="" x-data="{ open: false, iFrameLoading: true }" x-effect="if(open == false) { iFrameLoading = true; }">

    <spektrix-basket-summary id="spektrixBasketSummary" client-name="{{ nova_get_setting('spektrix_client_name') }}"
        custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}">
        <a href="/basket/" :class="open ? 'bg-yellow text-black z-40' : ''"
            @click.prevent="open = !open; $nextTick(() => $refs.searchInput.focus()); $dispatch('menutoggled', open)">
            @svg('basket', 'h-6 w-6 pt-0 p-0.5 pb-1')
            <span class="mobile-basket-count" data-basket-item-count></span>
        </a>
        <script>
            // Add 'hidden' attribute to <spektrix-basket-summary> to enable hidding empty basket.
            let showBasketIfNotEmpty = function() {
                var spektrixBasketSummary = document.getElementById(
                    'spektrixBasketSummary'
                );
                if (spektrixBasketSummary.getAttribute('count') > 0) {
                    spektrixBasketSummary.removeAttribute('hidden');
                }
            };
            setInterval(() => {
                showBasketIfNotEmpty();
            }, 1000);
        </script>
    </spektrix-basket-summary>

    <div @click.self="open = ! open; $dispatch('menutoggled', open)" x-show="open" x-transition:enter-start="opacity-0"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black bg-opacity-80 duration-300">
    </div>
    <div class="container fixed inset-0 left-auto z-20 flex h-screen w-full max-w-lg transform flex-col bg-sand p-12 transition-all delay-100 duration-200"
        x-show="open" x-transition:enter-start="translate-x-full" x-transition:leave-end="translate-x-full">
        <template x-if="open">
            <div>
                <div x-show="iFrameLoading" x-transition class="absolute inset-0 p-16">
                    @svg('loading', 'w-32 mx-auto block pt-36 text-black')
                </div>
                <iframe x-on:load="iFrameLoading = false" class="w-full transition-all"
                    :class="{ 'opacity-0': iFrameLoading }" id="SpektrixIFrame" name="SpektrixIFrame"
                    :src="`https://{{ nova_get_setting('spektrix_custom_domain') }}/{{ nova_get_setting('spektrix_client_name') }}/website/Basket2.aspx?resize=true`"></iframe>
            </div>
        </template>

    </div>
</div>
