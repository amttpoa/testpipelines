<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventAttendee;

class EventAttendeeController extends Controller
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
     * @param  \App\Models\EventAttendee  $eventAttendee
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, EventAttendee $eventAttendee)
    {
        return view('event-attendees.show', compact('event', 'eventAttendee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventAttendee  $eventAttendee
     * @return \Illuminate\Http\Response
     */
    public function edit(EventAttendee $eventAttendee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventAttendee  $eventAttendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event, EventAttendee $eventAttendee)
    {
        $eventAttendee->comments = $request->comments;
        $eventAttendee->checked_in = $request->checked_in;
        $eventAttendee->update();

        return redirect()->back()->with('success', 'Event Attendee Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventAttendee  $eventAttendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, EventAttendee $eventAttendee)
    {
        $eventAttendee->delete();
        return redirect()->route('admin.events.show', $event)->with('success', 'Event Attendee Deleted');
    }


    public function addAttendee(Request $request, Event $event)
    {
        if ($request->user_id > 0) {
            $eventAttendee = new EventAttendee();
            $eventAttendee->event_id = $event->id;
            $eventAttendee->user_id = $request->user_id;
            $eventAttendee->save();
            return back()->with('success', 'Attendee Added');
        } else {
            return back()->with('success', 'No User Selected');
        }
    }
}
