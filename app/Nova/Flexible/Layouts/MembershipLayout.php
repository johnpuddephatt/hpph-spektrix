<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Membership;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MembershipLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'membership';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Membership';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Membership', 'membership_name')
                ->options(static::cachedOptions('memberships', fn () => Membership::pluck('name', 'id')))
                ->searchable(),
        ];
    }

    public function getMembershipAttribute($value)
    {
        return Membership::find($this->membership_name);
    }
}
