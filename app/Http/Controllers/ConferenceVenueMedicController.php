<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\ConferenceVenueMedic;

class ConferenceVenueMedicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        $conferenceVenueMedics = ConferenceVenueMedic::where('conference_id', $conference->id)->get();
        return view('conference-venue-medics.index', compact('conference', 'conferenceVenueMedics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Conference $conference)
    {
        $medics = User::permission('medic')->orderBy('name')->pluck('name', 'id');
        return view('conference-venue-medics.create', compact('conference', 'medics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Conference $conference, Request $request)
    {
        $conferenceVenueMedic = new ConferenceVenueMedic;
        $conferenceVenueMedic->conference_id = $conference->id;
        $conferenceVenueMedic->venue_id = $request->venue_id;
        $conferenceVenueMedic->user_id = $request->user_id;
        $conferenceVenueMedic->date = $request->date;
        $conferenceVenueMedic->note = $request->note;
        $conferenceVenueMedic->save();

        return redirect()->route('admin.conference-venue-medics.index', $conference)->with('success', 'Medic Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, ConferenceVenueMedic $conferenceVenueMedic)
    {
        $medics = User::permission('medic')->orderBy('name')->pluck('name', 'id');
        return view('conference-venue-medics.edit', compact('conference', 'conferenceVenueMedic', 'medics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, ConferenceVenueMedic $conferenceVenueMedic)
    {
        $conferenceVenueMedic->venue_id = $request->venue_id;
        $conferenceVenueMedic->user_id = $request->user_id;
        $conferenceVenueMedic->date = $request->date;
        $conferenceVenueMedic->note = $request->note;
        $conferenceVenueMedic->update();

        return redirect()->route('admin.conference-venue-medics.index', $conference)->with('success', 'Medic Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, ConferenceVenueMedic $conferenceVenueMedic)
    {
        $conferenceVenueMedic->delete();

        return redirect()->route('admin.conference-venue-medics.index', $conference)->with('success', 'Medic Deleted');
    }
}
