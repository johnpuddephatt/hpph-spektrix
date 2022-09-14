<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\URL;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use NovaAttachMany\AttachMany;
use Spatie\TagsField\Tags;
use Laravel\Nova\Fields\BelongsTo;

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
    public static $title = "id";

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
                        "maxlength" => 100,
                    ],
                ])
                ->rules("required", "max:100"),
            Boolean::make("Published")
                ->showOnPreview()
                ->filterable(),
            Boolean::make("Featured")
                ->showOnPreview()
                ->filterable(),
            BelongsTo::make("User")->searchable(),
            Tags::make("Tags")
                ->limit(2)
                ->help("Select a maximum of two tags"),
            Textarea::make("Introduction")
                ->rows(3)
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 300,
                    ],
                ])
                ->alwaysShow()
                ->rules("required", "max:300"),
            AttachMany::make("Events")
                ->height("150px")
                ->showPreview(),
            Images::make("Featured image", "main")->rules("required"),
            NovaEditorJsField::make("Content")
                ->hideFromIndex()
                ->stacked()
                ->rules("required"),
            URL::make(
                "URL",
                fn() => $this->slug ? $this->url : "#"
            )->displayUsing(fn() => $this->slug ? "Visit" : "–"),
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
