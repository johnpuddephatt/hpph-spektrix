<?php

namespace App\Nova;

use Advoor\NovaEditorJs\NovaEditorJsField;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Opportunity extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Opportunity::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "title";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["id"];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()
                ->sortable()
                ->hide(),
            Text::make("Title")
                ->withMeta([
                    "extraAttributes" => [
                        "class" => "text-xl p-4 h-auto",
                        "maxlength" => 40,
                    ],
                ])
                ->rules("required", "max:40"),
            Textarea::make("Summary")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 300,
                        "rows" => 2,
                        "class" => "md:w-3/4",
                    ],
                ])
                ->hideFromIndex()
                ->rules("max:300", "required"),
            Select::make("Type")
                ->options([
                    "Full-time" => "Full-time",
                    "Part-time" => "Part-time",
                    "Voluntary" => "Voluntary",
                    "Other" => "Other",
                ])
                ->default("Full-time"),
            Text::make("Hours")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->rules("max:40"),
            Text::make("Application deadline")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->rules("max:40"),
            Text::make("Salary")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->rules("max:40"),
            Text::make("Responsible to")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->hideFromIndex()
                ->rules("max:40"),
            Text::make("Probation period")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->hideFromIndex()
                ->rules("max:40"),
            Text::make("Notice period")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->hideFromIndex()
                ->rules("max:40"),
            Text::make("Holidays")
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 40,
                    ],
                ])
                ->hideFromIndex()
                ->rules("max:40"),
            NovaEditorJsField::make("Content")
                ->rules("required")
                ->hideFromIndex()
                ->default(
                    // json_decode(
                    '{"time":1662912835013,"blocks":[{"id":"wkNAusAbIu","type":"header","data":{"text":"Job description","level":3}},{"id":"aqRrufPa83","type":"paragraph","data":{"text":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."}},{"id":"E22DgdztPU","type":"header","data":{"text":"Key responsibilities","level":3}},{"id":"sVHbrN7mYs","type":"list","data":{"style":"unordered","items":["Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua","Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat","Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur","Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum"]}},{"id":"JU_XYPyydP","type":"header","data":{"text":"How to apply","level":3}},{"id":"6o9pcCUka4","type":"paragraph","data":{"text":"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."}}],"version":"2.25.0"}'
                    //)
                ),
            URL::make("URL", fn() => $this->url)->displayUsing(fn() => "Visit"),
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
