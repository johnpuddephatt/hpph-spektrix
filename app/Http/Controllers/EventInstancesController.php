<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventInstancesController extends Controller
{
    public function __invoke(Event $event)
    {
        return $event->instances->load('strands')->each->append('availability');
    }
}
