<?php

namespace App\Nova\Flexible\Layouts;

// use Laravel\Nova\Fields\MultiSelect;

use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FundGroupLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'fund-group';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Fund group layout';

    public $collapsedPreviewAttribute = 'fund_group_title';

    public function getFundsAttribute($value)
    {
        return $this->flexible('funds', [
            'fund' => FundLayout::class,
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
            Text::make('Fund group title'),
            Flexible::make('Funds', 'funds')
                ->addLayout(FundLayout::class)
                ->fullWidth()
                ->button('Add fund'),
        ];
    }
}
