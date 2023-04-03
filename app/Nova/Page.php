<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;

use Alexwenzel\DependencyContainer\HasDependencies;

class Page extends Resource
{

    use HasDependencies;
    
    public static $group = "Content";

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

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
        return $query->withoutGlobalScope('published')->orderPagesByUrl();
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        if ($request->resourceId) {
            return $query->whereNotIn("id", [$request->resourceId]);
        }
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $fields = [
            
            ID::make()
                ->sortable()
                ->hide(),

            Text::make("Name")
                ->hideFromIndex(function (ResourceIndexRequest $request) {
                    return !$request->viaRelationship();
                })
                ->maxLength(100)->enforceMaxlength()
                ->withMeta([
                    "extraAttributes" => [
                        "class" => "text-xl p-4 h-auto",
                        "maxlength" => 100,
                    ],
                ])
                ->rules("required", "max:100"),
            Text::make("Name", function () {
                return $this->indented_name();
            })
                ->asHtml()
                ->hideFromDetail()                
                ->hideFromIndex(function (ResourceIndexRequest $request) {
                    return $request->viaRelationship();
                }),

            Slug::make("Slug")
                ->hideFromIndex()
                ->placeholder("Leave blank to generate automatically")
                ->rules("max:100"),
            Text::make("Subtitle")->maxLength(30)->enforceMaxlength()->hideFromIndex(),
            Boolean::make("Published")->showOnPreview()
                ->filterable()->hideWhenCreating(),
            Images::make("Image", "main"),
            Textarea::make("Introduction")->maxLength(200)->enforceMaxlength()
                ->rows(3)
                ->withMeta([
                    "extraAttributes" => [
                        "maxlength" => 200,
                        "class" => "md:w-3/4"
                    ],
                ])
                ->alwaysShow()
                ->rules("required", "max:350"),
   
            Select::make("Template")
                ->options(
                    \App\Models\Page::getAvailableTemplates($request->resourceId || $request->isResourceIndexRequest())
                )
                ->displayUsingLabels()->readonly(function ($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                })->help('The template value cannot be changed after page creation to prevent data loss. Some templates can only be used once.')->required()->rules("required"),

            Text::make("URL", function () {
                return "<a onclick='event.stopPropagation()' class='underline text-primary-500' target='_blank' href='{$this->URL}'>{$this->URL}<svg xmlns='http://www.w3.org/2000/svg' class='inline-block w-4 h-4 ml-1' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
              <path stroke-linecap='round' stroke-linejoin='round' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14' />
            </svg></a>";
            })->asHtml()
        ];
        
        if ($this->template !== 'home-page') {
            $fields = array_merge(
                            $fields,
                        [BelongsTo::make("Parent page", "parent", \App\Nova\Page::class)
                            ->nullable()
                            ->hideFromIndex()]
            );
        }

        if ($request->resourceId && $this->template) {
            $fields = array_merge(
                $fields,
                (new (config("page-templates")[$this->template][
                    "class"
                ]
                ))->fields($request)
            );
        }

        if ($this->template !== 'home-page') {
            $fields = array_merge($fields, [
                HasMany::make("Child pages", "children", \App\Nova\Page::class),
            ]);
        }

        return $fields;
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
