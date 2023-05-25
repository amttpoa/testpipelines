<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventAttendeesExport;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('start_date', 'DESC')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::permission('general-staff')->orderBy('name')->pluck('name', 'id');
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $regions = [];
        for ($i = 1; $i <= 8; $i++) {
            $regions[$i] = $i;
        }

        return view('events.create', compact('users', 'venues', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();
        $event->name = $request->name;
        $event->region = $request->region;
        $event->user_id = $request->user_id;
        $event->venue_id = $request->venue_id;
        $event->capacity = $request->capacity;
        $event->start_date = $request->start_date . ' ' . $request->start_time;
        $event->end_date = $request->start_date . ' ' . $request->end_time;
        $event->description = $request->description;
        $event->active = $request->active;
        $event->save();

        return redirect()->route('admin.events.edit', $event)->with('success', 'Event Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $users = User::permission('general-staff')->orderBy('name')->pluck('name', 'id');
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $regions = [];
        for ($i = 1; $i <= 8; $i++) {
            $regions[$i] = $i;
        }

        return view('events.edit', compact('event', 'users', 'venues', 'regions'));
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
        $event->name = $request->name;
        $event->region = $request->region;
        $event->user_id = $request->user_id;
        $event->venue_id = $request->venue_id;
        $event->capacity = $request->capacity;
        $event->start_date = $request->start_date . ' ' . $request->start_time;
        $event->end_date = $request->start_date . ' ' . $request->end_time;
        $event->description = $request->description;
        $event->active = $request->active;
        $event->update();

        return redirect()->route('admin.events.edit', $event)->with('success', 'Event Updated');
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


    public function export(Event $event)
    {
        // dd($trainingCourse);
        $file = $event->name . ' - ' . $event->start_date->format('m-d-y') . ' - Attendees.xlsx';

        return Excel::download(new EventAttendeesExport($event), $file);
    }
}
