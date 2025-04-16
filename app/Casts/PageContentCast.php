<?php

namespace App\Casts;

use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class PageContentCast extends FlexibleCast
{
    protected $layouts = [
        "section" => \App\Nova\Flexible\Layouts\SectionLayout::class,
        "fund-group" => \App\Nova\Flexible\Layouts\FundGroupLayout::class,
        "home-hero" => \App\Nova\Flexible\Layouts\HomeHeroLayout::class,
        "home-strands" => \App\Nova\Flexible\Layouts\HomeStrandsLayout::class,
        "home-carousel" => \App\Nova\Flexible\Layouts\HomeCarouselLayout::class,
        "home-instances" =>
        \App\Nova\Flexible\Layouts\HomeInstancesLayout::class,
        "statement_text" =>
        \App\Nova\Flexible\Layouts\StatementTextLayout::class,
        "text" => \App\Nova\Flexible\Layouts\TextLayout::class,
        "banner" => \App\Nova\Flexible\Layouts\BannerLayout::class,
        "journal-posts" => \App\Nova\Flexible\Layouts\JournalPostsLayout::class,
        "journal-post" => \App\Nova\Flexible\Layouts\JournalPostLayout::class,
        "opportunities" =>
        \App\Nova\Flexible\Layouts\OpportunitiesLayout::class,
        "key-features" => \App\Nova\Flexible\Layouts\KeyFeaturesLayout::class,
        "pages" => \App\Nova\Flexible\Layouts\PagesLayout::class,
        "membership-comparison" =>
        \App\Nova\Flexible\Layouts\MembershipComparisonLayout::class,
        "featured-membership" =>
        \App\Nova\Flexible\Layouts\FeaturedMembershipLayout::class,
        "simple-text" => \App\Nova\Flexible\Layouts\SimpleTextLayout::class,
        "image" => \App\Nova\Flexible\Layouts\ImageLayout::class,
        "image-pair" => \App\Nova\Flexible\Layouts\ImagePairLayout::class,
        "faqs" => \App\Nova\Flexible\Layouts\FaqsLayout::class,
        "single-faq" => \App\Nova\Flexible\Layouts\SingleFaqLayout::class,
        "film" => \App\Nova\Flexible\Layouts\FilmLayout::class,
        "team" => \App\Nova\Flexible\Layouts\TeamLayout::class,
        "link-banner" => \App\Nova\Flexible\Layouts\LinkBannerLayout::class,
        "quote" => \App\Nova\Flexible\Layouts\QuoteLayout::class,


        "merchandise-group" => \App\Nova\Flexible\Layouts\MerchandiseGroupLayout::class,
        "merchandise" => \App\Nova\Flexible\Layouts\MerchandiseLayout::class,
        // "feature" => \App\Nova\Flexible\Layouts\FeatureLayout::class,
        // "single-faq" => \App\Nova\Flexible\Layouts\SingleFaqLayout::class,
        // "child-page" => \App\Nova\Flexible\Layouts\ChildPageLayout::class,
        // "fund" => \App\Nova\Flexible\Layouts\FundLayout::class,
    ];
}
