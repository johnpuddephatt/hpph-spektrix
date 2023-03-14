<?php

return [
    "404-page" => [
        "class" => "\App\Nova\Templates\Error404PageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "standard-page" => [
        "class" => "\App\Nova\Templates\StandardPageTemplate",
        "unique" => false, // Whether more than one page can be created with this template
    ],
    "opportunities-page" => [
        "class" => "\App\Nova\Templates\OpportunitiesPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "home-page" => [
        "class" => "\App\Nova\Templates\HomePageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "sectioned-page" => [
        "class" => "\App\Nova\Templates\SectionedPageTemplate",
        "unique" => false, // Whether more than one page can be created with this template
    ],
    "funds-page" => [
        "class" => "\App\Nova\Templates\FundsPageTemplate",
        "unique" => false, // Whether more than one page can be created with this template
    ],
    "journal-page" => [
        "class" => "\App\Nova\Templates\JournalPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "shop-page" => [
        "class" => "\App\Nova\Templates\ShopPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "voucher-page" => [
        "class" => "\App\Nova\Templates\VoucherPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "memberships-page" => [
        "class" => "\App\Nova\Templates\MembershipsPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
];
