<?php

namespace App\Casts;

use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class PageCast extends FlexibleCast
{
    protected $layouts = [
        "home_hero" => \App\Nova\Flexible\Layouts\HomeHeroLayout::class,
        "home_instances" =>
            \App\Nova\Flexible\Layouts\HomeInstancesLayout::class,
        "statement_text" =>
            \App\Nova\Flexible\Layouts\StatementTextLayout::class,
        "banner_with_text" =>
            \App\Nova\Flexible\Layouts\BannerWithTextLayout::class,
        "image_carousel" =>
            \App\Nova\Flexible\Layouts\ImageCarouselLayout::class,
        "journal-posts" => \App\Nova\Flexible\Layouts\JournalPostsLayout::class,
    ];
}
