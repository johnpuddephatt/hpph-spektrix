<?php

namespace App\Nova\Flexible\Layouts;

// use Laravel\Nova\Fields\MultiSelect;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;

use Outl1ne\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Flexible;

class FundGroupLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "fund-group";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Fund group layout";

    public function getFundsAttribute($value)
    {
        return $this->flexible("funds", [
            "fund" => \App\Nova\Flexible\Layouts\FundLayout::class,
        ]);
    }

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make("Fund group title"),
            Flexible::make("Funds", "funds")
                ->addLayout(\App\Nova\Flexible\Layouts\FundLayout::class)
                ->button("Add fund"),
        ];
    }
}
