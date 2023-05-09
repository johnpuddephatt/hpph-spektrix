<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Panel;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
// use Spatie\TagsField\Tags;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Trin4ik\NovaSwitcher\NovaSwitcher;

class Post extends Resource
{
    public static $group = "Content";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

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
    public static $search = ["title"];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScope("published");
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make(__("ID"), "id")
                ->sortable()
                ->hide(),
            Text::make("Title")
                ->withMeta([
                    "extraAttributes" => [
                        "class" => "text-xl p-4 h-auto",
                    ],
                ])
                ->rules("required", "max:100")
                ->maxlength(100)
                ->enforceMaxlength(),
            Text::make("Subtitle")
                ->rules("max:50")
                ->maxlength(50)
                ->enforceMaxlength()
                ->hideFromIndex()
                ->help("E.g. Episode 5: In conversation with Park Chan-Wook"),
            Text::make("Summary")
                ->rules("max:120")
                ->maxlength(120)
                ->enforceMaxlength()
                ->hideFromIndex()
                ->help("A short line summarising the content of this post"),

            Boolean::make("Published")
                ->showOnPreview()
                ->filterable(),
            Date::make("Published date", "created_at"),

            Boolean::make("Featured")
                ->showOnPreview()
                ->filterable(),
            BelongsTo::make("User")
                ->searchable()
                ->hideFromIndex(),
            Tag::make("Tags")->hideFromIndex(),

            Tag::make("Events")
                ->displayAsList()
                ->hideFromIndex(),
            Tag::make("Seasons")
                ->displayAsList()
                ->hideFromIndex(),
            Tag::make("Strands")
                ->displayAsList()
                ->hideFromIndex(),
            Images::make("Image", "main")->rules("required"),
            Panel::make("Content", [
                Textarea::make("Introduction")
                    ->rows(3)
                    ->maxlength(300)
                    ->enforceMaxlength()
                    ->alwaysShow()
                    ->rules("required", "max:300"),
                NovaEditorJsField::make("Content")
                    ->hideFromIndex()
                    ->stacked()
                    ->rules("required")
                    ->hideFromDetail(),
                Text::make("Content", function () {
                    return view("components.editorjs", [
                        "content" => $this->content,
                    ])->render();
                })
                    ->asHtml()
                    ->onlyOnDetail(),
            ]),
            URL::make("URL", fn() => $this->slug ? $this->url : "#")
            ->displayUsing(fn() => $this->slug ? "Visit" : "–"),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
