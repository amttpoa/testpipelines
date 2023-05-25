<?php

namespace App\Http\Controllers;

use App\Models\Radio;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $radios = Radio::orderBy('order')->get()->groupBy('field');
        return view('radios.index', compact('radios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function show(Radio $radio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function edit(Radio $radio)
    {
        return view('radios.edit', compact('radio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Radio $radio)
    {
        $radio->name = $request->name;
        $radio->description = $request->description;
        $radio->update();
        return redirect()->route('admin.radios.index')->with('success', 'Radio Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Radio  $radio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Radio $radio)
    {
        //
    }
}
