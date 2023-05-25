<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Training;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = Training::orderBy('order')->get();
        return view('trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $instructors = User::role('Staff Instructor')->orderBy('name')->pluck('name', 'id');
        return view('trainings.create', compact('venues', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $training = new Training();
        $training->name = $request->name;
        $training->slug = Str::slug($request->name);
        $training->hours = $request->hours;
        $training->days = $request->days;
        $training->price = $request->price;
        $training->order = $request->order;
        $training->short_description = $request->short_description;
        $training->description = $request->description;
        $training->empty_message = $request->empty_message;
        $training->active = $request->active == 'true' ? 1 : 0;
        $training->save();

        return redirect()->route('admin.trainings.index')->with('success', 'Training Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        return view('trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $instructors = User::role('Staff Instructor')->orderBy('name')->pluck('name', 'id');
        return view('trainings.edit', compact('training', 'venues', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training)
    {
        $training->name = $request->name;
        $training->slug = Str::slug($request->name);
        $training->hours = $request->hours;
        $training->days = $request->days;
        $training->price = $request->price;
        $training->order = $request->order;
        $training->short_description = $request->short_description;
        $training->description = $request->description;
        $training->empty_message = $request->empty_message;
        $training->active = $request->active == 'true' ? 1 : 0;
        $training->update();

        return redirect()->route('admin.trainings.index')->with('success', 'Training Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        //
    }
}
