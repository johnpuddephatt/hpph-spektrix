@production

    @webComponent('spektrix-basket-summary')

    <spektrix-basket-summary hidden id="spektrixBasketSummary"
        client-name="{{ nova_get_setting('spektrix_client_name') }}"
        custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}">
        <a href="/basket/">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="mobile-basket-count" data-basket-item-count></span>
            <div class="basket-text">
                <span data-basket-item-count></span> item(s) (<span data-basket-summary-currency></span><span
                    data-basket-summary-basket-total></span>)
            </div>
        </a>
        <script>
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

@endproduction
