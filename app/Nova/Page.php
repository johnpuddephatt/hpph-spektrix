<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Http\Requests\NovaRequest;
use Advoor\NovaEditorJs\NovaEditorJs;

class Page extends Resource
{
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
    public static $title = "title";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ["title"];

    public static function indexQuery(NovaRequest $request, $query)
    {
        $ids_ordered = implode(
            ",",
            \App\Models\Page::all()
                ->sortBy("URL")
                ->pluck("id")
                ->toArray()
        );
        if ($ids_ordered) {
            $query->getQuery()->orders = [];
            $query->orderByRaw("FIELD(id, $ids_ordered)");
        }
        return $query;
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        return $query->whereNotIn("id", [$request->resourceId]);
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
            ID::make()
                ->sortable()
                ->hideFromIndex(),

            Text::make("Title")
                ->hideFromIndex()
                ->required(),
            Text::make("Title", function () {
                if ($this->parent_page) {
                    return "&nbsp;&mdash;&nbsp;&nbsp;&nbsp;{$this->title}";
                } else {
                    return $this->title;
                }
            })
                ->asHtml()
                ->onlyOnIndex()
                ->required(),
            Text::make("URL", function () {
                return "<a onclick='event.stopPropagation()' class='underline text-primary-500' target='_blank' href='{$this->URL}'>{$this->URL}<svg xmlns='http://www.w3.org/2000/svg' class='inline-block w-4 h-4 ml-1' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14' />
</svg></a>";
            })->asHtml(),
            BelongsTo::make("Parent page", "parent_page", "\App\Nova\Page")
                ->nullable()
                ->hideFromIndex(),
            NovaEditorJs::make("Content")->hideFromIndex(),
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
