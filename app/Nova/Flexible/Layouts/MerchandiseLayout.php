<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Product;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class MerchandiseLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'merchandise';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Merchandise layout';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('', 'merchandise_name')
                ->options(static::cachedOptions('products', fn () => Product::withoutGlobalScope('published')->get()->pluck('name', 'id')))
                ->searchable(),
        ];
    }

    public function getMerchandiseAttribute()
    {
        return Product::withoutGlobalScope('published')->find($this->merchandise_name);
    }
}
