<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Alexwenzel\DependencyContainer\DependencyContainer;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Ebess\AdvancedNovaMediaLibrary\Fields\Media;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Panel;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Flexible;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Season extends Resource
{
    use HasSortableRows {
        indexQuery as indexSortableQuery;
    }

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
        $query->withoutGlobalScopes(["published", "enabled"])->orderBy(
            "name",
            "asc"
        );
        return parent::indexQuery($request, static::indexSortableQuery($request, $query));
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
            DateTime::make("Force sync until", "force_enabled_until")
                ->help("This will force the season to be displayed until this date, even it does not appear in the Spektrix import.")
                ->showOnPreview()
                ->nullable(),
            Select::make("Display type", "display_type")->options([
                "instances" => "Instances (default)",
                "events" => "Events",
            ])->displayUsingLabels()->default('instances')->hideFromIndex(),
            // Image::make("Logo")
            //     ->acceptedTypes(".svg")
            //     ->disableDownload(),
            Media::make("Video")
                ->conversionOnForm("thumb")
                ->conversionOnDetailView("thumb")
                ->conversionOnIndexView("thumb"),
            Images::make("Main image", "main"),
            Textarea::make("Short description")
                ->rows(2)
                ->hideFromIndex()
                ->maxLength(120)
                ->enforceMaxlength(),
            Textarea::make("Description")
                ->rows(3)
                ->hideFromIndex()
                ->maxLength(250)
                ->enforceMaxlength(),
            Textarea::make("Additional description")
                ->rows(3)
                ->hideFromIndex()
                ->maxLength(800)
                ->enforceMaxlength(),
            Image::make("Funders logo", "funders_logo")->disableDownload()->help('Logos should have a transparent background and be in PNG format. Individual logos should be approximately 300-400px wide. Multiple logos can be artworked on a canvas 800px wide.')->hideFromIndex(),
            Tag::make("Posts")->displayAsList()->hideFromIndex(),

            new Panel("Content", [
                Flexible::make("Content", "content")
                    ->addLayout(\App\Nova\Flexible\Layouts\FaqsLayout::class)
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\JournalPostLayout::class
                    )
                    ->addLayout(\App\Nova\Flexible\Layouts\QuoteLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\PagesLayout::class)
                    ->addLayout(\App\Nova\Flexible\Layouts\MerchandiseGroupLayout::class)

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
