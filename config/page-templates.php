<?php

return [
    "standard-page" => [
        "class" => "\App\Nova\Templates\StandardPageTemplate",
        "unique" => false, // Whether more than one page can be created with this template
    ],
    "jobs-page" => [
        "class" => "\App\Nova\Templates\JobsPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "simple-page" => [
        "class" => "\App\Nova\Templates\SimplePageTemplate",
        "unique" => false, // Whether more than one page can be created with this template
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
    "team-page" => [
        "class" => "\App\Nova\Templates\TeamPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
    "journal-page" => [
        "class" => "\App\Nova\Templates\JournalPageTemplate",
        "unique" => true, // Whether more than one page can be created with this template
    ],
];
