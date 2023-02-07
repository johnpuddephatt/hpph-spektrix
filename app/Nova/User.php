<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;
use Whitecube\NovaFlexibleContent\Flexible;

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

            Avatar::make("Avatar")
                ->maxWidth(50)
                ->disableDownload()
                ->store(function (Request $request, $model) {
                    $image = Image::make($request->avatar)
                        ->fit(200, 200)
                        ->encode("jpg", 80);

                    Storage::disk("public")->put(
                        "/avatar/" . $request->avatar->getClientOriginalName(),
                        $image
                    );

                    return "/avatar/" .
                        $request->avatar->getClientOriginalName();
                }),

            Text::make("Name")
                ->sortable()
                ->rules("required", "max:255"),

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

            Panel::make("Favourite films", [
                // Image::make("Favourite film image"),
                Flexible::make("Favourite films", "extras->favourite_films")
                    ->addLayout("Favourite films", "favourite_films", [
                        Text::make("Film name"),
                    ])
                    ->button("Add a film"),
            ]),

            Panel::make("Quote", [Textarea::make("Quote", "extras->quote")]),
            Panel::make("Favourite film quote", [
                // Image::make("Film quote image"),
                Textarea::make("Quote", "extras->film_quote->quote"),
                Text::make("Author", "extras->film_quote->author"),
                Text::make("Film", "extras->film_quote->film"),
                Text::make("Year", "extras->film_quote->year"),
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
