<?php

namespace App\Nova;

use App\Models\SignupForm as SignupFormModel;
use App\Models\SpektrixStatement;
use App\Models\SpektrixTag;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\MultiselectField\Multiselect;

class SignupForm extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = SignupFormModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name'];

    public static $group = 'Content';

    public static function label()
    {
        return 'Signup forms';
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

            Text::make('Name')
                ->rules('required', 'max:255')
                ->help(
                    'Admin-only label so you can tell your forms apart, e.g. &quot;Access needs signup&quot;. Not shown to visitors.'
                ),

            Text::make('Heading')
                ->nullable()
                ->rules('max:255')
                ->hideFromIndex(),

            Textarea::make('Intro')
                ->nullable()
                ->hideFromIndex()
                ->help('Optional text shown above the form fields.'),

            Textarea::make('Success message')
                ->nullable()
                ->hideFromIndex()
                ->help(
                    'Shown once the visitor has signed up. Leave blank for the default.'
                ),

            Multiselect::make('Tags')
                ->options(static::tagOptions())
                ->reorderable()
                ->saveAsJSON()
                ->nullable()
                ->help(
                    'The options this form offers, in the order they should appear. Only tags Spektrix publishes to the web are listed &mdash; automatic tags are excluded because Spektrix recalculates them, so opting in would be undone at the next sync. Run <code>fetch:tags</code> after adding one in Spektrix.'
                ),

            Multiselect::make('Contact preferences', 'statements')
                ->options(static::statementOptions())
                ->reorderable()
                ->saveAsJSON()
                ->nullable(),
        ];
    }

    /**
     * Synced tags, grouped under their Spektrix tag group name.
     */
    protected static function tagOptions(): array
    {
        return SpektrixTag::with('group')
            ->get()
            ->mapWithKeys(
                fn (SpektrixTag $tag) => [
                    $tag->id => [
                        'label' => $tag->name,
                        'group' => $tag->group?->name ?? 'Ungrouped',
                    ],
                ]
            )
            ->all();
    }

    protected static function statementOptions(): array
    {
        return SpektrixStatement::pluck('text', 'id')->all();
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
