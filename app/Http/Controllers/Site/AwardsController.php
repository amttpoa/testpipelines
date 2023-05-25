<?php

namespace App\Http\Controllers\Site;

use App\Models\Award;
use Illuminate\Http\Request;
use App\Models\AwardSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AwardsController extends Controller
{
    public function index()
    {
        $awards = Award::orderBy('order')->get();
        return view('site.awards.index', compact('awards'));
    }
    public function show(Award $award)
    {
        return view('site.awards.show', compact('award'));
    }
    public function store(Request $request, Award $award)
    {
        $submission = new AwardSubmission();
        $submission->award_id = $award->id;
        $submission->name_submitter = $request->name_submitter;
        $submission->agency_submitter = $request->agency_submitter;
        $submission->email_submitter = $request->email_submitter;
        $submission->phone_submitter = $request->phone_submitter;
        $submission->preferred_contact = $request->preferred_contact;
        $submission->incident_date = $request->incident_date;
        $submission->story = $request->story;
        // $submission->image = $request->image;
        // $submission->logo = $request->logo;
        $submission->video = $request->video;
        $submission->name_candidate = $request->name_candidate;
        $submission->agency_candidate = $request->agency_candidate;

        if ($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;
            Storage::disk('s3')->put('award-submissions/' . $newfileName, file_get_contents($request->image));
            $submission->image = $newfileName;
        }
        if ($request->logo) {
            $fileName = $request->logo->getClientOriginalName();
            $fileExt = $request->logo->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;
            Storage::disk('s3')->put('award-submissions/' . $newfileName, file_get_contents($request->logo));
            $submission->logo = $newfileName;
        }

        // foreach (['keethm@gmail.com', 'keethm@gmail.com'] as $recipient) {
        //     Mail::to($recipient)->send("New award submission");
        // }


        $submission->save();
        return back()->with('success', 'Thank you for submitting an award person.');
    }
}
