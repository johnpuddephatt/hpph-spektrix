<?php

namespace App\Nova\Templates;

use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class TicketSubscriptionsTemplate
{
    // Name displayed in CMS
    public function name(): string
    {
        return 'Ticket subscriptions page';
    }

    // Fields displayed in CMS
    public function fields(Request $request): array
    {
        return [
            new Panel('Page content', [
                Flexible::make('Content', 'content')
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\TicketSubscriptionGroupLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\TextLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\FaqsLayout::class)
                    ->button('Add content'),
            ]),
        ];
    }

    // Resolve data for serialization
    public function resolve($page)
    {
        return $page->content;
    }
}
