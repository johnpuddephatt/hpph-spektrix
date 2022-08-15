@webComponent('spektrix-login-status')

<spektrix-login-status client-name="{{ nova_get_setting('spektrix_client_name') }}"
    custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}" id="login-status">
    <a aria-label="My account" title="My account" href="/account" class="flex flex-row" data-logged-in-container
        style="display: none;">
        @svg('user', 'h-6 w-6 pt-0.5 p-1')
    </a>

    <a aria-label="Log in" title="Log in" href="/account" class="flex flex-row" data-logged-out-container>
        @svg('user', 'h-6 w-6 pt-0.5 p-1')
    </a>

</spektrix-login-status>
