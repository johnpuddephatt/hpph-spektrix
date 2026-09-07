<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Membership;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SingleMembershipLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'single-membership';

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Single membership';

    public $collapsedPreviewAttribute = 'title';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Title'),
            Text::make('Subtitle'),
            Select::make('Membership', 'membership_id')
                ->options(static::cachedOptions('memberships', fn () => Membership::pluck('name', 'id')))
                ->searchable()
                ->displayUsingLabels(),
        ];
    }

    public function getMembershipAttribute()
    {
        return Membership::find($this->membership_id);
    }
}
