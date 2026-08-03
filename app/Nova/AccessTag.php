<?php

namespace App\Nova;

use App\Models\AccessTag as AccessTagModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
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
            Text::make('Slug')
                ->sortable()
                ->rules('required', 'alpha_dash', 'max:255', 'unique:access_tags,slug,{{resourceId}}')
                ->help('Must match the instance field this tag represents, e.g. <code>toddler_friendly</code>. Letters, numbers, dashes and underscores only.'),
            Text::make('Abbreviation')->sortable()->rules('required', 'max:255', 'unique:access_tags,abbreviation,{{resourceId}}'),
            Text::make('Read More Link')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255')
                ->help('Optional. Linked from the booking warning as "Find out more".'),
            Text::make('Description')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255')
                ->help('Displayed in the access key alongside the showtimes list.'),
            Textarea::make('Booking Warning')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:1000')
                ->alwaysShow()
                ->help('Optional. If set, anyone selecting a screening with this tag must acknowledge this message before they can choose seats. Leave empty for tags that do not need to interrupt booking.'),
        ];
    }
}
