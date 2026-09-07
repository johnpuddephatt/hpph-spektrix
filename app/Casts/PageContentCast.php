<?php

namespace App\Casts;

use App\Nova\Flexible\Layouts\BannerLayout;
use App\Nova\Flexible\Layouts\FaqsLayout;
use App\Nova\Flexible\Layouts\FeaturedMembershipLayout;
use App\Nova\Flexible\Layouts\FilmLayout;
use App\Nova\Flexible\Layouts\FundGroupLayout;
use App\Nova\Flexible\Layouts\HomeCarouselLayout;
use App\Nova\Flexible\Layouts\HomeHeroLayout;
use App\Nova\Flexible\Layouts\HomeInstancesLayout;
use App\Nova\Flexible\Layouts\HomeStrandsLayout;
use App\Nova\Flexible\Layouts\ImageLayout;
use App\Nova\Flexible\Layouts\ImagePairLayout;
use App\Nova\Flexible\Layouts\JournalPostLayout;
use App\Nova\Flexible\Layouts\JournalPostsLayout;
use App\Nova\Flexible\Layouts\KeyFeaturesLayout;
use App\Nova\Flexible\Layouts\LinkBannerLayout;
use App\Nova\Flexible\Layouts\MembershipComparisonLayout;
use App\Nova\Flexible\Layouts\MerchandiseGroupLayout;
use App\Nova\Flexible\Layouts\MerchandiseLayout;
use App\Nova\Flexible\Layouts\OpportunitiesLayout;
use App\Nova\Flexible\Layouts\PagesLayout;
use App\Nova\Flexible\Layouts\ProgrammeIntroductionLayout;
use App\Nova\Flexible\Layouts\ProgrammeSliderLayout;
use App\Nova\Flexible\Layouts\QuoteLayout;
use App\Nova\Flexible\Layouts\SectionLayout;
use App\Nova\Flexible\Layouts\SignupFormLayout;
use App\Nova\Flexible\Layouts\SimpleTextLayout;
use App\Nova\Flexible\Layouts\SingleFaqLayout;
use App\Nova\Flexible\Layouts\SingleMembershipLayout;
use App\Nova\Flexible\Layouts\StatementTextLayout;
use App\Nova\Flexible\Layouts\TeamLayout;
use App\Nova\Flexible\Layouts\TextLayout;
use App\Nova\Flexible\Layouts\TicketSubscriptionGroupLayout;
use App\Nova\Flexible\Layouts\TicketSubscriptionLayout;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class PageContentCast extends FlexibleCast
{
    protected $layouts = [
        'section' => SectionLayout::class,
        'fund-group' => FundGroupLayout::class,
        'home-hero' => HomeHeroLayout::class,
        'home-strands' => HomeStrandsLayout::class,
        'home-carousel' => HomeCarouselLayout::class,
        'home-instances' => HomeInstancesLayout::class,
        'statement_text' => StatementTextLayout::class,
        'text' => TextLayout::class,
        'banner' => BannerLayout::class,
        'journal-posts' => JournalPostsLayout::class,
        'journal-post' => JournalPostLayout::class,
        'opportunities' => OpportunitiesLayout::class,
        'key-features' => KeyFeaturesLayout::class,
        'pages' => PagesLayout::class,
        'membership-comparison' => MembershipComparisonLayout::class,
        'featured-membership' => FeaturedMembershipLayout::class,
        'single-membership' => SingleMembershipLayout::class,
        'simple-text' => SimpleTextLayout::class,
        'image' => ImageLayout::class,
        'image-pair' => ImagePairLayout::class,
        'faqs' => FaqsLayout::class,
        'single-faq' => SingleFaqLayout::class,
        'film' => FilmLayout::class,
        'team' => TeamLayout::class,
        'link-banner' => LinkBannerLayout::class,
        'quote' => QuoteLayout::class,

        'ticket-subscription-group' => TicketSubscriptionGroupLayout::class,
        'ticket-subscription' => TicketSubscriptionLayout::class,

        'merchandise-group' => MerchandiseGroupLayout::class,
        'merchandise' => MerchandiseLayout::class,
        'signup-form' => SignupFormLayout::class,

        // Strand and season page bodies. See App\Models\Concerns\HasProgrammePageContent.
        'programme-introduction' => ProgrammeIntroductionLayout::class,
        'programme-slider' => ProgrammeSliderLayout::class,
        // "feature" => \App\Nova\Flexible\Layouts\FeatureLayout::class,
        // "single-faq" => \App\Nova\Flexible\Layouts\SingleFaqLayout::class,
        // "child-page" => \App\Nova\Flexible\Layouts\ChildPageLayout::class,
        // "fund" => \App\Nova\Flexible\Layouts\FundLayout::class,
    ];
}
