<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Advoor\NovaEditorJs\NovaEditorJs;
use Advoor\NovaEditorJs\NovaEditorJsField;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;

use Laravel\Nova\Fields\Color;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Panel;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Flexible;

class Strand extends Resource
{
    public static $group = "Programme";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Strand::class;

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
    public static $search = ["name"];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withoutGlobalScopes(["published", "enabled"]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->hide(),
            Text::make("Name")
                ->withMeta([
                    "extraAttributes" => [
                        "class" => "text-xl p-4 h-auto",
                        "maxlength" => 50,
                    ],
                ])
                ->readOnly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),
            Boolean::make("Published"),
            Boolean::make("Synced", "enabled")
                ->readonly()
                ->showOnPreview()
                ->filterable(),
            Color::make("Color"),
            Image::make("Logo")
                ->acceptedTypes(".svg")
                ->disableDownload(),
            Image::make("Simplified logo", "logo_simple")
                ->acceptedTypes(".svg")
                ->disableDownload(),
            Media::make("Video")
                ->conversionOnForm("thumb")
                ->conversionOnDetailView("thumb")
                ->conversionOnIndexView("thumb"),
            Images::make("Main image", "main"),
            Textarea::make("Short description")
                ->rows(2)
                ->hideFromIndex(),
            Textarea::make("Description")
                ->rows(3)
                ->hideFromIndex(),
            Boolean::make("Show on event card")->hideFromIndex(),
            Boolean::make("Show on instance card")->hideFromIndex(),
            Boolean::make("Show in booking path")->hideFromIndex(),
            Tag::make("Posts")->displayAsList(),

            new Panel("Content", [
                Flexible::make("Content", "content")
                    ->addLayout(\App\Nova\Flexible\Layouts\FaqsLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\QuoteLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\LinkBannerLayout::class
                    )
                    ->button("Add a section")
                    ->stacked(),
            ]),
            HasMany::make("Screenings", "instances", "\App\Nova\Instance"),
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

    public function showWhenMembersVoicesEnabled(
        $field,
        NovaRequest $request,
        FormData $formData
    ) {
        if ($formData["content->members_voices->enable"] ?? false) {
            $field->show();
        }
    }
}
