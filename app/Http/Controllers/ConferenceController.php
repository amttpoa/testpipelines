<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferenceAttendee;
use App\Models\EmailSent;
use App\Models\Venue;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware(['can:full-access'], ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conferences = Conference::orderBy('start_date', 'DESC')->get();
        return view('conferences.index', compact('conferences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('conferences.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $conference = new Conference();
        $conference->name = $request->name;
        $conference->slug = $request->slug;
        $conference->start_date = $request->start_date;
        $conference->end_date = $request->end_date;
        $conference->save();

        return redirect()->route('admin.conferences.index')->with('success', 'Conference Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference)
    {
        return view('conferences.show', compact('conference'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference)
    {
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        return view('conferences.edit', compact('conference', 'venues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference)
    {
        $conference->conference_visible = $request->conference_visible == 'true' ? 1 : 0;
        $conference->courses_visible = $request->courses_visible == 'true' ? 1 : 0;
        $conference->registration_active = $request->registration_active == 'true' ? 1 : 0;
        $conference->vendor_active = $request->vendor_active == 'true' ? 1 : 0;
        $conference->name = $request->name;
        $conference->slug = $request->slug;
        $conference->start_date = $request->start_date;
        $conference->end_date = $request->end_date;
        $conference->registration_start_date = $request->registration_start_date;
        $conference->registration_end_date = $request->registration_end_date;
        $conference->vendor_start_date = $request->vendor_start_date;
        $conference->vendor_end_date = $request->vendor_end_date;
        $conference->description = $request->description;
        $conference->venue_id = $request->venue_id;
        $conference->price = $request->price;
        $conference->save();

        return redirect()->route('admin.conferences.show', $conference)->with('success', 'Conference Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conference  $conference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference)
    {
        //
    }


    public function roster(Conference $conference)
    {
        return view('conferences.roster', compact('conference'));
    }
}
