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
            Flexible::make('Email sections', 'content')->addLayout('Email Events Section', 'email_events_section', [
                Select::make("Columns")->options(["2" => "2", "3" => "3"])->default("3"),
                Multiselect::make("Films", "films")

                    ->reorderable()
                    ->asyncResource(\App\Nova\Event::class)
                    ->stacked()
                    ->fullWidth()
                    ->saveAsJSON()
                    ->help(
                        "<style>.multiselect__option--selected { display: none !important } .multiselect__tag { display: block; padding: 10px 20px 10px 5px !important; margin-bottom: 5px !important} .multiselect__tag-icon { line-height: 32px; } .multiselect__tag-icon:after { font-size: 20px;}</style>"
                    ),
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
