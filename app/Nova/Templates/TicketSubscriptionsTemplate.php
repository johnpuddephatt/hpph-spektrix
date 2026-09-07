<?php

namespace App\Nova\Templates;

use App\Nova\Flexible\Layouts\TicketSubscriptionGroupLayout;
use Illuminate\Http\Request;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Collection;

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

    /**
     * A page with no content of its own lists every pass on sale, so the page
     * is useful the moment it is created and keeps up with Spektrix on its own.
     * Adding any content here takes that over, exactly as it does elsewhere.
     */
    public function resolve($page)
    {
        $content = $page->content;

        if ($content instanceof Collection && $content->isNotEmpty()) {
            return $content;
        }

        // An empty group resolves to every pass on sale; see the layout.
        return new Collection([
            (new TicketSubscriptionGroupLayout(null, null, []))->setModel($page),
        ]);
    }
}
