<?php

namespace App\Nova;

use App\Nova\Flexible\Layouts\ImageLayout;
use App\Nova\Flexible\Layouts\ImagePairLayout;
use App\Nova\Flexible\Layouts\TextLayout;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return 'Shop';
    }

    public static function singularLabel()
    {
        return 'Product';
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name'];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes(['enabled', 'published']);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->hide(),
            Text::make('Name'),
            Text::make('Spektrix name')->readOnly(),
            Slug::make('Slug')
                ->from('Name')
                ->hideFromIndex()
                ->rules([Rule::requiredIf(fn () => $request->published)]),
            Text::make('Price')->readOnly(),
            Text::make('Type')->readOnly(),
            Text::make('Postage')->readOnly(),
            Boolean::make('Synced', 'enabled')
                ->readonly()
                ->showOnPreview()
                ->filterable(),
            Boolean::make('Published')->showOnPreview(),
            Textarea::make('Description'),
            Images::make('Image', 'main'),
            Panel::make('Content', [
                Flexible::make('', 'content')
                    ->addLayout('Product details', 'product-details', [
                        KeyValue::make('', 'details')
                            ->keyLabel('Detail')
                            ->valueLabel('Value')
                            ->actionText('Add detail'),
                    ])
                    ->addLayout(TextLayout::class)
                    ->addLayout(
                        ImagePairLayout::class
                    )
                    ->addLayout(ImageLayout::class)
                    ->hideFromIndex()
                    ->button('Add section'),
            ]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            Actions\FetchShopData::make()->standalone(),

        ];
    }
}
