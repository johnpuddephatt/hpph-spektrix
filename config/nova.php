<?php

use Laravel\Nova\Actions\ActionResource;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Http\Middleware\Authorize;
use Laravel\Nova\Http\Middleware\BootTools;
use Laravel\Nova\Http\Middleware\DispatchServingNovaEvent;
use Laravel\Nova\Http\Middleware\HandleInertiaRequests;

return [
    "storage_disk" => env("NOVA_STORAGE_DISK", "public"),

    "brand" => [
        "logo" =>
            "<svg class='h-8' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 62 39.389' width='62' height='39.389'><defs><clipPath id='prefix__a'><path fill='#ffe621' d='M0 0h62v39.389H0z'/></clipPath></defs><g clip-path='url(#prefix__a)' fill='#ffe621'> <rect style='fill:#000000;' width='55.332821' height='19.011789' x='3.6888547' y='9.9315319' /><path d='M25.56 15.678h-2.994v3.608h2.994c1.543 0 2.157-.762 2.157-1.8s-.614-1.8-2.157-1.8'/><path d='M37.35 15.678h-2.994v3.608h2.994c1.543 0 2.157-.762 2.157-1.8s-.613-1.8-2.157-1.8'/><path d='M42.305 0h-22.61a19.695 19.695 0 000 39.389h22.61a19.695 19.695 0 000-39.389M18.867 26.2h-3.012v-5.241h-5.021V26.2H7.821V13.186h3.013v4.984h5.021v-4.984h3.013zm6.768-4.426h-3.068V26.2h-3.013V13.186h6.081c3.087 0 5.1 1.432 5.1 4.3s-2.009 4.3-5.1 4.3m11.789 0h-3.068V26.2h-3.013V13.186h6.081c3.087 0 5.1 1.432 5.1 4.3s-2.009 4.3-5.1 4.3M54.179 26.2h-3.013v-5.241h-5.021V26.2h-3.012V13.186h3.013v4.984h5.021v-4.984h3.013z'/></g></svg>",
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova App Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to display the name of the application within the UI
    | or in other locations. Of course, you're free to change the value.
    |
    */

    "name" => env("NOVA_APP_NAME", env("APP_NAME")),

    /*
    |--------------------------------------------------------------------------
    | Nova Domain Name
    |--------------------------------------------------------------------------
    |
    | This value is the "domain name" associated with your application. This
    | can be used to prevent Nova's internal routes from being registered
    | on subdomains which do not need access to your admin application.
    |
    */

    "domain" => env("NOVA_DOMAIN_NAME", null),

    /*
    |--------------------------------------------------------------------------
    | Nova App URL
    |--------------------------------------------------------------------------
    |
    | This URL is where users will be directed when clicking the application
    | name in the Nova navigation bar. You are free to change this URL to
    | any location you wish depending on the needs of your application.
    |
    */

    "url" => env("APP_URL", "/"),

    /*
    |--------------------------------------------------------------------------
    | Nova Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where Nova will be accessible from. Feel free to
    | change this path to anything you like. Note that this URI will not
    | affect Nova's internal API routes which aren't exposed to users.
    |
    */

    "path" => "/nova",

    /*
    |--------------------------------------------------------------------------
    | Nova Authentication Guard
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the authentication guard that will
    | be used to protect your Nova routes. This option should match one
    | of the authentication guards defined in the "auth" config file.
    |
    */

    "guard" => env("NOVA_GUARD", null),

    /*
    |--------------------------------------------------------------------------
    | Nova Password Reset Broker
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the password broker that will be
    | used when passwords are reset. This option should mirror one of
    | the password reset options defined in the "auth" config file.
    |
    */

    "passwords" => env("NOVA_PASSWORDS", null),

    /*
    |--------------------------------------------------------------------------
    | Nova Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every Nova route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can just stick with this stack.
    |
    */

    "middleware" => [
        "web",
        HandleInertiaRequests::class,
        DispatchServingNovaEvent::class,
        BootTools::class,
    ],

    "api_middleware" => ["nova", Authenticate::class, Authorize::class],
    /*
    |--------------------------------------------------------------------------
    | Nova Pagination Type
    |--------------------------------------------------------------------------
    |
    | This option defines the visual style used in Nova's resource pagination
    | views. You may select between "simple", "load-more", and "links" for
    | your applications. Feel free to adjust this option to your choice.
    |
    */

    "pagination" => "simple",

    /*
    |--------------------------------------------------------------------------
    | Nova Action Resource Class
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to specify a custom resource class
    | to use instead of the type that ships with Nova. You may use this to
    | define any extra form fields or other custom behavior as required.
    |
    */

    "actions" => [
        "resource" => ActionResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Nova Currency
    |--------------------------------------------------------------------------
    |
    | This configuration option allows you to define the default currency
    | used by the Currency field within Nova. You may change this to a
    | valid ISO 4217 currency code to suit your application's needs.
    |
    */

    "currency" => "USD",
];
