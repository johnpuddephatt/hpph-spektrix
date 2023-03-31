<?php

namespace App\Nova\Flexible\Layouts;

use Whitecube\NovaFlexibleContent\Layouts\Layout;

use Spatie\MediaLibrary\HasMedia;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Whitecube\NovaFlexibleContent\Concerns\HasMediaLibrary;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;

class FilmLayout extends Layout implements HasMedia
{
    use HasMediaLibrary;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = "film";

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "Film layout";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Images::make("Film image", "image"),
            Text::make("Error message", "message")
                ->maxLength(40)
                ->enforceMaxlength(),
            Text::make("Film title", "title"),
            Text::make("Film year", "year"),
            Text::make("Film certificate", "certificate"),
            Select::make("Film rating", "rating")->options([1, 2, 3, 4, 5]),
            Textarea::make("Film description", "description"),
        ];
    }
}
