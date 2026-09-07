<?php

namespace App\Nova\Flexible\Layouts;

use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MembershipComparisonLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'membership-comparison';

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Membership comparison';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Flexible::make('Memberships', 'memberships')
                ->addLayout(MembershipLayout::class)
                ->button('Add membership'),
            File::make('Video')->acceptedTypes('video/*'),

        ];
    }

    public function menuLabel(): ?string
    {
        // This block has no heading of its own to borrow a label from.
        return 'Memberships';
    }

    public function getMembershipsAttribute()
    {
        return $this->flexible('memberships', [
            'membership' => MembershipLayout::class,
        ]);
    }
}
