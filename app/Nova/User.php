<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use Outl1ne\NovaSimpleRepeatable\SimpleRepeatable;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\KeyValue;
use NormanHuth\Values\Values;

class User extends Resource
{
    public static function label()
    {
        return "Staff";
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = "name";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["id", "name", "email"];

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

            Images::make("Main image", "main")->rules([
                Rule::requiredIf(fn() => $request->show_in_directory),
            ]),

            Text::make("Name")
                ->sortable()
                ->rules("required", "max:255"),

            Slug::make("Slug")->from("name"),

            Text::make("Email")
                ->sortable()
                ->rules("required", "email", "max:254")
                ->creationRules("unique:users,email")
                ->updateRules("unique:users,email,{{resourceId}}"),

            Password::make("Password")
                ->onlyOnForms()
                ->creationRules("required", Rules\Password::defaults())
                ->updateRules("nullable", Rules\Password::defaults()),

            Panel::make("Settings", [
                Boolean::make("Show in directory"),
                Boolean::make("Enable login"),
            ]),

            Panel::make("Role", [
                Text::make("Role title"),
                Textarea::make("Role description"),
            ]),

            Panel::make("Content", [
                Flexible::make("", "content")
                    ->addLayout("Favourite films", "favourite-films", [
                        KeyValue::make("Favourite films")
                            ->valueLabel("Year")
                            ->keyLabel("Film"),
                    ])
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\SimpleTextLayout::class
                    )
                    ->button("Add section"),
            ]),
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
