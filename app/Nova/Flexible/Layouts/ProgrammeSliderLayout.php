<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Event;
use App\Models\Instance;
use App\Nova\Flexible\Layouts\Concerns\BelongsToProgrammePage;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class ProgrammeSliderLayout extends Layout
{
    use BelongsToProgrammePage;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'programme-slider';

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = "What's on";

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Text::make('Pretitle')->help(
                'Optional. Defaults to “What’s on”.'
            ),
            Text::make('Title')->help(
                'Optional. Defaults to the name of this strand or season.'
            ),
        ];
    }

    /**
     * Note the getAttribute() calls: inside a layout, $this->title is the
     * layout's *display* title, not the title an editor typed.
     */
    public function getPretitleTextAttribute(): string
    {
        $pretitle = $this->getAttribute('pretitle');

        return filled($pretitle) ? (string) $pretitle : 'What’s on';
    }

    public function getTitleTextAttribute(): string
    {
        $title = $this->getAttribute('title');

        return filled($title) ? (string) $title : (string) $this->model?->name;
    }

    /**
     * The screenings — or the events, when the page is set to display whole
     * events rather than individual screenings — attached to this strand or
     * season, already sorted for the slider.
     */
    public function getEntriesAttribute()
    {
        if (! $this->model) {
            return collect();
        }

        return $this->model->display_type == 'events'
            ? Event::getEventsForSlider($this->subject_type, $this->model->name)
            : Instance::getInstancesForSlider(
                $this->subject_type,
                $this->model->name
            );
    }
}
