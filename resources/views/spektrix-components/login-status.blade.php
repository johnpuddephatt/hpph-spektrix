@push('webComponents', '#spektrix-login-status')

<spektrix-login-status class="block" client-name="{{ $settings['spektrix_client_name'] }}"
    custom-domain="{{ $settings['spektrix_custom_domain'] }}" id="login-status">
    <a aria-label="My account" title="My account" href="/account" class="block" data-logged-in-container
        style="display: none;" :class="{ 'max-lg:!hidden': scrolled }">
        @svg('user', 'h-8 w-8 p-1')
    </a>

    <a aria-label="Log in" title="Log in" href="/account" class="block" data-logged-out-container
        :class="{ 'max-lg:!hidden': scrolled }">
        @svg('user', 'h-8 w-8 p-0.5 pb-1')
    </a>

</spektrix-login-status>
