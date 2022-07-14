<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Spatie\MediaLibrary\HasMedia;

use Whitecube\NovaFlexibleContent\Flexible;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use App\Nova\Flexible\Layouts\TestLayout;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Fields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;

use Advoor\NovaEditorJs\NovaEditorJs;
use Eminiarts\Tabs\Tabs;

use Hpph\TemplateFields\HeadingField;
use Hpph\TemplateFields\BasicHeaderField;
use Hpph\TemplateFields\BannerField;

use Laravel\Nova\Fields\FormData;

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
        return $query->orderPagesByUrl();
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
        return [
            ID::make()
                ->sortable()
                ->hideFromIndex(),

            Text::make("Title")
                ->hideFromIndex()
                ->rules("required", "max:255"),

            Slug::make("Slug")
                ->hideFromIndex()
                ->placeholder("Leave blank to generate automatically")
                ->rules("max:100"),

            Text::make("Title", function () {
                return $this->indented_title();
            })
                ->asHtml()
                ->onlyOnIndex(),

            Text::make("URL", function () {
                return "<a onclick='event.stopPropagation()' class='underline text-primary-500' target='_blank' href='{$this->URL}'>{$this->URL}<svg xmlns='http://www.w3.org/2000/svg' class='inline-block w-4 h-4 ml-1' fill='none' viewBox='0 0 24 24' stroke='currentColor' stroke-width='2'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14' />
</svg></a>";
            })->asHtml(),

            HasMany::make("Child pages", "child_pages", \App\Nova\Page::class),
            BelongsTo::make("Parent page", "parent_page", \App\Nova\Page::class)
                ->nullable()
                ->hideFromIndex(),

            Select::make("Header type")
                ->options([
                    "default" => "Default",
                    "light" => "Light",
                ])
                ->default("default"),

            Select::make("Header position")
                ->options([
                    "default" => "Default",
                    "fixed" => "Fixed",
                ])
                ->default("default"),

            Flexible::make("Content")
                ->onlyOnForms()
                ->addLayout("HTML", "html", [
                    Code::make("html_content")
                        ->language("htmlmixed")
                        ->stacked(),
                ])
                ->addLayout("Text", "editorjs", [
                    NovaEditorJs::make("EditorJS")->stacked(),
                    // NovaEditorJsField::make("EditorJS")->stacked(),
                ])
                ->addLayout("Banner", "banner", [BannerField::make("banner")])
                ->addLayout("Basic Header", "basic_header", [
                    BasicHeaderField::make("basic_header"),
                ])

                ->addLayout(\App\Nova\Flexible\Layouts\HomeHeroLayout::class)

                ->addLayout("Statement text", "statement_text", [
                    Textarea::make("Title"),
                ])
                ->addLayout("Banner with text", "banner_with_text", [
                    Text::make("Title"),
                    Text::make("Subtitle"),
                ])

                ->addLayout("Home instances", "home_instances", [
                    Select::make("Display")->options([
                        "day" => "Today/tommorrow",
                        "week" => "This week/next week",
                    ]),
                ])

                ->addLayout("Heading", "heading", [
                    HeadingField::make("Heading"),
                ])
                ->stacked()
                ->confirmRemove()
                ->rules("required"),
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
