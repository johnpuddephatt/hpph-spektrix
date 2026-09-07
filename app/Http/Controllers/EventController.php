<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     * @return Response
     */
    public function show($event)
    {
        $event = Event::where('slug', $event)
            ->with(
                'featuredVideo',
                'featuredImage',
                'gallery',
                'latest_post.tags',
                'related_event.featuredImage',
                'latest_post.featuredImage',
            )
            ->firstOrFail();

        $current_event_instance_ids = $event->instances()->pluck('id');

        return view('events.show', [
            'event' => $event,
            'strand_sliders' => $event->strands->map(function ($strand) use ($current_event_instance_ids) {
                return [
                    'strand' => $strand,
                    'color' => $strand->color,
                    'type' => $strand->display_type,
                    'entries' => $strand->display_type == 'events'
                        ? Event::getEventsForSlider('strand', $strand->name, $current_event_instance_ids)
                        : Instance::getInstancesForSlider('strand', $strand->name, $current_event_instance_ids),
                ];
            }),
            'season_sliders' => $event->seasons->map(function ($season) use ($current_event_instance_ids) {
                return [
                    'season' => $season,
                    'type' => $season->display_type,
                    'entries' => $season->display_type == 'events'
                        ? Event::getEventsForSlider('season', $season->name, $current_event_instance_ids)
                        : Instance::getInstancesForSlider('season', $season->name, $current_event_instance_ids),
                ];
            }),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
