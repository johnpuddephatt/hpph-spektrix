<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Fund;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FundLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'fund';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Fund layout';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('', 'fund_name')
                ->options(static::cachedOptions('funds', fn () => Fund::pluck('name', 'id')))
                ->searchable(),
        ];
    }

    public function getFundAttribute()
    {
        return Fund::find($this->fund_name);
    }
}
