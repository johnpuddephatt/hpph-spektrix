@webComponent('spektrix-login-status')

<spektrix-login-status client-name="{{ nova_get_setting('spektrix_client_name') }}"
    custom-domain="{{ nova_get_setting('spektrix_custom_domain') }}" id="login-status">
    <a href="/account" class="flex flex-row" data-logged-in-container style="display: none;">
        <span>
            My account
        </span>
        <!-- @svg('user', 'ml-1 h-6 w-6') -->

    </a>

    <a href="/account" class="flex flex-row" data-logged-out-container>
        <span>Login</span>
        <!-- @svg('user', 'ml-1 h-6 w-6') -->

    </a>

</spektrix-login-status>
