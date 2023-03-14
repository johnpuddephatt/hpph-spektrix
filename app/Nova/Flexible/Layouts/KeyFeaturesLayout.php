<?php namespace App\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Whitecube\NovaFlexibleContent\Layouts\Layout;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;
class KeyFeaturesLayout extends Layout
{
    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "key-features";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Key features";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Flexible::make("Features")
                ->addLayout(\App\Nova\Flexible\Layouts\FeatureLayout::class)
                ->limit(3)
                ->button("Add feature"),
        ];
    }

    public function getFeaturesAttribute()
    {
        return $this->flexible("features", [
            "feature" => \App\Nova\Flexible\Layouts\FeatureLayout::class,
        ]);
    }
}
