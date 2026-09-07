<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Membership;
use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FeaturedMembershipLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'featured-membership';

    public $collapsedPreviewAttribute = 'title';

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Featured membership';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Video')->acceptedTypes('video/*'),
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
