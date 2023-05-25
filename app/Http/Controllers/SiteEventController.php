<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendee;
use Illuminate\Http\Request;

class SiteEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::where('start_date', '>=', now())->where('active', 1)->orderBy('start_date')->get();
        return view('site.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('site.events.show', compact('event'));
    }

    public function register(Request $request, Event $event)
    {
        $eventAttendee = new EventAttendee;
        $eventAttendee->user_id = auth()->user()->id;
        $eventAttendee->comments = $request->comments;
        $event->eventAttendees()->save($eventAttendee);

        return redirect()->back()->with('success', 'You have been registered for this event');
    }
}
