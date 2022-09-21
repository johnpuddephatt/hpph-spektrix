<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;

class PublishEvents extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = "Publish";

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $success = 0;
        $failure = 0;

        foreach ($models as $model) {
            if ($model->featuredImage) {
                $success++;
                $model->update(["published" => true]);
            } else {
                $failure++;
            }
        }

        if ($failure) {
            return Action::danger(
                "$failure event(s) were not published due to missing images."
            );
        } else {
            return Action::message("$success event(s) published");
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
