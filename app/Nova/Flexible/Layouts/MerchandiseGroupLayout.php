<?php

namespace App\Nova\Flexible\Layouts;

// use Laravel\Nova\Fields\MultiSelect;

use Laravel\Nova\Fields\Text;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MerchandiseGroupLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'merchandise-group';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Merchandise group layout';

    public function getMerchandiseAttribute($value)
    {
        return $this->flexible('merchandise', [
            'merchandise' => MerchandiseLayout::class,
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
            Text::make('Merchandise group pre-title', 'pretitle'),
            Text::make('Merchandise group title', 'title')->required(),
            NovaSwitcher::make('Display merchandise images', 'display_images'),
            NovaSwitcher::make('Display quantity controls', 'display_quantity_controls'),
            Flexible::make('Merchandise', 'merchandise')
                ->addLayout(MerchandiseLayout::class)
                ->button('Add merchandise'),
        ];
    }
}
