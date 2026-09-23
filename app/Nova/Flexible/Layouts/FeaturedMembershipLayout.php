<?php

namespace App\Nova\Flexible\Layouts;

use App\Models\Instance;
use App\Models\Membership;
use App\Nova\Flexible\Layouts\Concerns\AppearsInPageMenu;
use App\Nova\Flexible\Layouts\Concerns\CachesOptions;
use App\Nova\Flexible\Layouts\Concerns\HasPageMenuEntry;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class FeaturedMembershipLayout extends Layout implements HasPageMenuEntry
{
    use AppearsInPageMenu;
    use CachesOptions;

    /**
     * The layout's unique identifier
     *
     * @var string
     */
    protected $name = 'featured-membership';

    public $collapsedPreviewAttribute = 'title';

    protected $casts = [];

    /**
     * The displayed title
     *
     * @var string
     */
    protected $title = 'Featured membership';

    /**
     * Get the fields displayed by the layout.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Video')->acceptedTypes('video/*'),
            Text::make('Title'),
            Text::make('Subtitle'),
            Select::make('Membership', 'membership_id')
                ->options(static::cachedOptions('memberships', fn () => Membership::pluck('name', 'id')))
                ->searchable()
                ->displayUsingLabels(),
            Boolean::make('Show 15–25 film of the week', 'show_film_of_the_week')
                ->help('Lists films whose screenings are tagged "15-25 FOTW" in Spektrix.'),
        ];
    }

    public function getMembershipAttribute()
    {
        return Membership::find($this->membership_id);
    }

    /**
     * Films with screenings tagged 15-25 FOTW in Spektrix, as NOW (run under way)
     * and NEXT (run not yet started). The tag goes on next week's film a few days
     * before the current one finishes, so two can be live at once.
     *
     * Whether a run has started comes from its earliest tagged screening,
     * including past ones: the import disables screenings once they drop out of
     * the Spektrix feed, but they keep their flag.
     */
    public function getFilmsOfTheWeekAttribute(): Collection
    {
        if (! $this->show_film_of_the_week) {
            return collect();
        }

        return Instance::withoutGlobalScopes(['future', 'enabled'])
            ->where('fotw_15_25', true)
            ->where('start', '>', now()->subWeeks(2))
            // Past screenings are disabled by the import; future ones only if pulled from Spektrix.
            ->where(fn ($query) => $query->where('enabled', true)->orWhere('start', '<', now()))
            ->with('event')
            ->get()
            ->groupBy('event_id')
            ->filter(fn ($instances) => $instances->last()->start->isFuture())
            ->map(fn ($instances) => (object) [
                'event' => $instances->first()->event,
                'started' => $instances->first()->start->isPast(),
                'first' => $instances->first()->start,
                'last' => $instances->last()->start,
            ])
            ->sortBy('first')
            ->values();
    }
}
