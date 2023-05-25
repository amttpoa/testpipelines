<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use Illuminate\Http\Request;
use App\Exports\LiveFireExport;
use App\Models\LiveFireSubmission;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LiveFireSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        $submissions = LiveFireSubmission::whereIn('vendor_registration_submission_id', function ($query) use ($conference) {
            $query->select(DB::raw('id'))
                ->from('vendor_registration_submissions')
                ->where('conference_id', $conference->id)
                ->where('deleted_at', null);
        })
            ->get();

        $submissions = $submissions
            ->map(function ($item) {
                $bringing = $item->bringing;
                $bringing = explode(', ', $bringing);
                $bringing = collect($bringing);
                $item->bringingCollection = $bringing;
                return $item;
            });

        // dd($submissions);

        return view('live-fire-submissions.index', compact('conference', 'submissions'));
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
     * @param  \App\Models\liveFireSubmission  $liveFireSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(liveFireSubmission $liveFireSubmission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\liveFireSubmission  $liveFireSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, LiveFireSubmission $liveFireSubmission)
    {
        return view('live-fire-submissions.edit', compact('conference', 'liveFireSubmission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\liveFireSubmission  $liveFireSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, LiveFireSubmission $liveFireSubmission)
    {
        $liveFireSubmission->bringing = $request->bringing;
        $liveFireSubmission->firearm = $request->firearm;
        $liveFireSubmission->caliber = $request->caliber;
        $liveFireSubmission->share = $request->share;
        $liveFireSubmission->share_with = $request->share_with;
        $liveFireSubmission->description = $request->description;
        $liveFireSubmission->update();

        return redirect()->route('admin.live-fire-submissions.index', $conference)->with('success', 'Live Fire Submission updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\liveFireSubmission  $liveFireSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, LiveFireSubmission $liveFireSubmission)
    {
        $liveFireSubmission->delete();
        return redirect()->route('admin.live-fire-submissions.index', $conference)->with('success', 'Live Fire Submission deleted');
    }

    public function export(Conference $conference)
    {

        $file = 'Live Fire Submission - ' . now()->format('m-d-Y') . '.xlsx';
        // dd($file);
        return Excel::download(new LiveFireExport($conference), $file);
    }
}
