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
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Panel;
use Trin4ik\NovaSwitcher\NovaSwitcher;
use Whitecube\NovaFlexibleContent\Flexible;
use App\Nova\Concerns\ShowsScreeningDates;
use App\Nova\Filters\SyncStatus;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Season extends Resource
{
    use ShowsScreeningDates;
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

    /**
     * Drag order: `sort_order` is what orders the season menu and the homepage
     * carousel on the public site, so the index has to show that order for
     * dragging to mean anything. The `order` global scope is dropped so it can't
     * fight the ordering nova-sortable applies.
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return static::indexSortableQuery(
            $request,
            static::withScreeningAggregates(
                $query->withoutGlobalScopes(["published", "enabled", "order"])
            )
        );
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
                ->help(
                    "Only change the capitalisation. The name is what links this season to Spektrix, " .
                        "so any other edit will stop screenings being attached to it."
                ),

            ...$this->screeningDateFields(),

            Boolean::make("Published"),
            Boolean::make("Synced", "enabled")
                ->readonly()
                ->showOnPreview()
                ->filterable(),
            Boolean::make("Programme?", "show_in_programme")
                ->showOnPreview()
                ->filterable(),
            DateTime::make("Force sync until", "force_enabled_until")
                ->help("This will force the season to be displayed until this date, even it does not appear in the Spektrix import.")
                ->showOnPreview()
                ->hideFromIndex()
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
                ->hideFromIndex(),
            Images::make("Main image", "main")->hideFromIndex(),
            Image::make("Hero overlay image", "hero_overlay_image")->hideFromIndex(),
            NovaSwitcher::make("HPPH Presents", 'hpph_presents')
                ->help('Enable the HPPH presents text above the season title.')
                ->default(true)
                ->hideFromIndex()
                ->nullable(),
            NovaSwitcher::make("Show header", "show_header")
                ->help('Enable to show the season name and short description in the header.')
                ->hideFromIndex(),
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
            Trix::make("Additional description")
                ->hideFromIndex(),
            Image::make("Funders logo", "funders_logo")->disableDownload()->help('Logos should be black on a transparent background and in PNG format. Individual logos should be approximately 300-400px wide. Multiple logos can be artworked in a grid of two or three columns and can be 600 - 800px wide.')->hideFromIndex(),
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
                        \App\Nova\Flexible\Layouts\SingleMembershipLayout::class
                    )
                    ->addLayout(
                        \App\Nova\Flexible\Layouts\LinkBannerLayout::class
                    )
                    ->button("Add a section")
                    ->stacked()
                    ->hideFromIndex(),
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
        return [new SyncStatus(forceable: true)];
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
