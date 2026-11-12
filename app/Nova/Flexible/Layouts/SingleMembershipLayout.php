<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Membership;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class SingleMembershipLayout extends Layout
{
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'single-membership';

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Single membership';

    public $collapsedPreviewAttribute = 'title';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Style')
                ->options([
                    'feature' => 'Feature: logo on black, with an add to basket button',
                    'details' => 'Details: description, benefits and price',
                ])
                ->displayUsingLabels()
                ->default('feature')
                ->help('Details takes the description, benefits and image from the membership under Memberships.'),
            Text::make('Title')->help('In the details style, falls back to the membership name.'),
            Text::make('Subtitle'),
            Select::make('Membership', 'membership_id')
                ->options(static::cachedOptions('memberships', fn () => Membership::pluck('name', 'id')))
                ->searchable()
                ->displayUsingLabels(),
        ];
    }

    public function getMembershipAttribute()
    {
        return Membership::find($this->membership_id);
    }

    /**
     * Which view to render. Blocks saved before the style option existed have
     * no value, and they were all the feature style.
     */
    public function getVariantAttribute(): string
    {
        return $this->style === 'details' ? 'details' : 'feature';
    }
}
