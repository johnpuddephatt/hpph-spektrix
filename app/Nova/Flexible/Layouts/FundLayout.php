<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;

class FundLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "fund";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Fund layout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("", "fund_name")
                ->options(\App\Models\Fund::pluck("name", "id"))
                ->searchable(),
        ];
    }

    public function getFundAttribute()
    {
        return \App\Models\Fund::find($this->fund_name);
    }
}
