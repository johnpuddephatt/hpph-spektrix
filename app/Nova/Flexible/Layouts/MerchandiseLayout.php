<?php

namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;

class MerchandiseLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "merchandise";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Merchandise layout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make("", "merchandise_name")
                ->options(\App\Models\Product::pluck("name", "id"))
                ->searchable(),
        ];
    }

    public function getMerchandiseAttribute()
    {
        return \App\Models\Product::find($this->merchandise_name);
    }
}
