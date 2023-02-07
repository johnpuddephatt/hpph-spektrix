@push('webComponents', '#spektrix-memberships')

@foreach (\App\Models\Membership::showByBookingPath()->get() as $membership)
    <spektrix-memberships id="spektrixMemberships" client-name="{{ $settings['spektrix_client_name'] }}"
        custom-domain="{{ $settings['spektrix_custom_domain'] }}" membership-id="801ARDQDDMGGJKKRTNTJBMCCMMBCPQKCR"
        class="mt-8 block max-w-xl">
        <details>
            <summary class="flex cursor-default flex-row items-center gap-2 focus-within:outline-none">
                @svg('plus', 'h-6 w-6 p-1')
                <h3 class="type-regular">{{ $membership->name }}</h3>
                <span class="type-xs-mono rounded bg-yellow px-2 py-1">{{ $membership->price }}</span>
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
