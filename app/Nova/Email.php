<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Whitecube\NovaFlexibleContent\Flexible;
use Laravel\Nova\Fields\Repeater;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Outl1ne\MultiselectField\Multiselect;

class Email extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Email>
     */
    public static $model = \App\Models\Email::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Title')->required(),
            Flexible::make('Email sections', 'content')
                ->addLayout('Email Events Section', 'email_events_section', [
                    Select::make("Layout")->fullWidth()->stacked()->options(["rows" => "Rows", 1 => "1", 2 => "2", 3 => "3"])->default("rows"),

                    Flexible::make('Events', 'events')
                        ->stacked()->addLayout('Event', 'event', [
                            Select::make('Event')->fullWidth()->stacked()->searchable()->options(
                                \App\Models\Event::all()->pluck('name', 'id')
                            )->displayUsingLabels(),
                            Text::make('Additional info')->stacked()->fullWidth()
                        ])
                ])

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
