<?php

namespace App\Nova\Flexible\Layouts;

// use Laravel\Nova\Fields\MultiSelect;

use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;

use Outl1ne\MultiselectField\Multiselect;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Flexible;

class MerchandiseGroupLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "merchandise-group";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Merchandise group layout";

    public function getMerchandiseAttribute($value)
    {
        return $this->flexible("merchandise", [
            "merchandise" => \App\Nova\Flexible\Layouts\MerchandiseLayout::class,
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
            Text::make("Merchandise group pre-title", "pretitle"),
            Text::make("Merchandise group title", "title")->required(),
            NovaSwitcher::make("Display merchandise images", 'display_images'),
            NovaSwitcher::make("Display quantity controls", 'display_quantity_controls'),
            Flexible::make("Merchandise", "merchandise")
                ->addLayout(\App\Nova\Flexible\Layouts\MerchandiseLayout::class)
                ->button("Add merchandise"),
        ];
    }
}
