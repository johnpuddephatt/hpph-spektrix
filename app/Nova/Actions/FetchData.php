<?php

namespace App\Nova\Actions;

use App\Jobs\FetchEventData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class FetchData extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Fetch events from Spektrix';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        dispatch(new FetchEventData);

        return Action::message('Event fetch initiated');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
