@webComponent('spektrix-memberships')

@foreach (\App\Models\Membership::showByBookingPath()->get() as $membership)
    <spektrix-memberships id="spektrixMemberships" client-name="{{ nova_get_setting('spektrix_client_name') }}"
        custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}"
        membership-id="801ARDQDDMGGJKKRTNTJBMCCMMBCPQKCR" class="mt-8 block">
        <details>
            <summary class="flex cursor-default flex-row items-center gap-2">
                <div class="h-6 w-6 rounded bg-gray-light"></div>
                <h3 class="type-subtitle">{{ $membership->name }}</h3>
                <span class="type-label rounded bg-yellow px-2 py-1">{{ $membership->price }}</span>
            </summary>
            <div class="pt-4">
                <div class="mb-4">
                    {!! $membership->long_description !!}</div>
                <button class="ml-auto rounded bg-gray px-16 py-1 font-bold hover:bg-yellow" data-submit-membership>Buy
                    membership</button>
                <label for="autorenew">
                    <input type="checkbox" name="autorenew" data-set-autorenew>Autorenew?
                </label>
                <div data-success-container style="display: none;">Added to basket!</div>
                <div data-fail-container style="display: none;">Could not add to basket.</div>
            </div>
        </details>
    </spektrix-memberships>
@endforeach
