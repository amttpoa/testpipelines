<?php

namespace App\Http\Controllers;

use App\Models\AwardSubmission;
use Illuminate\Http\Request;

class AwardSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awardSubmissions = AwardSubmission::orderBy('created_at', 'DESC')->get();
        return view('award-submissions.index', compact('awardSubmissions'));
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
     * @param  \App\Models\AwardSubmission  $awardSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(AwardSubmission $awardSubmission)
    {
        return view('award-submissions.show', compact('awardSubmission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AwardSubmission  $awardSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(AwardSubmission $awardSubmission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AwardSubmission  $awardSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AwardSubmission $awardSubmission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AwardSubmission  $awardSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(AwardSubmission $awardSubmission)
    {
        //
    }
}
