<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show($event)
    {
        $event = Event::where("slug", $event)
            ->with(
                "featuredVideo",
                "featuredImage",
                "gallery",
                "latest_post.tags",
                "related_event.featuredImage",
                "latest_post.featuredImage",
            )
            ->firstOrFail();

        $current_event_instance_ids = $event->instances()->pluck('id');

        return view("events.show", [
            'event' => $event,
            "strand_related" =>
            $event->strand ? ($event->strand->display_type == 'events' ? Event::getEventsForSlider('strand', $event->strand->name, $current_event_instance_ids) : Instance::getInstancesForSlider('strand', $event->strand->name, $current_event_instance_ids)) : [],
            "season_related" => $event->season ? ($event->season->display_type == 'events' ? Event::getEventsForSlider('season', $event->season->name, $current_event_instance_ids) :
                Instance::getInstancesForSlider('season', $event->season->name, $current_event_instance_ids)) : [],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
