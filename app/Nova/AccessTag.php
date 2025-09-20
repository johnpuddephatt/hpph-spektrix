<?php

namespace App\Nova;

use App\Models\AccessTag as AccessTagModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class AccessTag extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = AccessTagModel::class;



    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'label',
        'abbreviation'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \\Illuminate\\Http\\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hidden(),
            Text::make('Label')->sortable()->rules('required', 'max:255'),
            Text::make('Slug')->sortable()->rules('max:255', 'unique:access_tags,slug,{{resourceId}}'),
            Text::make('Abbreviation')->sortable()->rules('required', 'max:255', 'unique:access_tags,abbreviation,{{resourceId}}'),
            Text::make('Read More Link')->hideFromIndex()->nullable(),
            Text::make('Description')->hideFromIndex()->nullable(),
            Text::make('Booking Warning')->hideFromIndex()->nullable(),
        ];
    }
}
