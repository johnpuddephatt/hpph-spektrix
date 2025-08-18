@push('webComponents', '#spektrix-login-status')

<spektrix-login-status class="block" client-name="{{ $settings['spektrix_client_name'] }}"
    custom-domain="{{ $settings['spektrix_custom_domain'] }}" id="login-status">
    <a aria-label="My account" title="My account" href="/account" class="hover:text-yellow transition block"
        data-logged-in-container style="display: none;" :class="{ '!hidden': scrolled && !nav_open }">
        @svg('user', 'w-6 h-6 p-0.5')
    </a>

    <a aria-label="Log in" title="Log in" href="/account" class="hover:text-yellow transition block"
        data-logged-out-container :class="{ '!hidden': scrolled && !nav_open }">
        @svg('user', 'h-6 w-6  pb-0.5')
    </a>

</spektrix-login-status>
