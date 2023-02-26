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

class Season extends Resource
{
    public static $group = "Programme";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Season::class;

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
            Image::make("Logo")
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
            Tag::make("Posts")->displayAsList(),
            Panel::make("Members’ voices", [
                NovaSwitcher::make(
                    "Enabled?",
                    "content->members_voices->enabled"
                )->hideFromIndex(),
                DependencyContainer::make([
                    Textarea::make(
                        "Quote",
                        "content->members_voices->quote"
                    )->rows(3),
                    Text::make(
                        "Member name",
                        "content->members_voices->name"
                    )->hideFromIndex(),
                    Images::make(
                        "Image",
                        "content->members_voices->image"
                    )->hideFromIndex(),
                    Text::make(
                        "Member role/description",
                        "content->members_voices->role"
                    )->hideFromIndex(),
                ])->dependsOn("content->members_voices->enabled", 1),
            ]),
            Panel::make("More information", [
                NovaSwitcher::make(
                    "Enabled?",
                    "content->more_information->enabled"
                )->hideFromIndex(),
                DependencyContainer::make([
                    Text::make("Title", "content->more_information->title")
                        ->default("Information & FAQs")
                        ->hideFromIndex(),

                    Flexible::make("FAQs", "content->more_information->faqs")
                        ->addLayout("Question", "question", [
                            Text::make("Question"),
                            NovaEditorJsField::make("Answer"),
                        ])
                        ->button("Add a question"),
                ])->dependsOn("content->more_information->enabled", 1),
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
