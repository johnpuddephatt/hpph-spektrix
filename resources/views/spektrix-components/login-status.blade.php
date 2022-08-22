@webComponent('spektrix-login-status')

<spektrix-login-status class="block" client-name="{{ $settings['spektrix_client_name'] }}"
    custom-domain="{{ $settings['spektrix_custom_domain'] }}" id="login-status">
    <a aria-label="My account" title="My account" href="/account" class="block" data-logged-in-container
        style="display: none;">
        @svg('user', 'h-10 w-10 lg:h-6 lg:w-6 p-1')
    </a>

    <a aria-label="Log in" title="Log in" href="/account" class="block" data-logged-out-container>
        @svg('user', 'h-10 w-10 lg:h-6 lg:w-6 p-0.5 pb-1')
    </a>

</spektrix-login-status>
