<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseAttendee;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ConferenceAttendee;
use App\Models\SurveyConferenceCourseLine;
use App\Models\SurveyConferenceCourseSubmission;

class DashboardConferenceController extends Controller
{

    public function index()
    {
        return view('site.dashboard.conferences.index');
    }


    public function show(ConferenceAttendee $conferenceAttendee)
    {
        if ($conferenceAttendee->user_id != auth()->user()->id) {
            abort(403, 'This ain\'t yours');
        }

        // $courseAttendees = CourseAttendee::where('conference_attendee_id', $conferenceAttendee->id)
        //     ->join('courses', 'course_attendees.course_id', '=', 'courses.id')
        //     ->orderBy('courses.start_date')
        //     ->get();

        $courseAttendees = CourseAttendee::where('conference_attendee_id', $conferenceAttendee->id)
            ->with(
                'course',
                function ($query) {
                    return $query
                        ->orderBy('start_date');
                }
            )
            ->get();

        // dd($courseAttendees);
        return view('site.dashboard.conferences.show', compact('conferenceAttendee', 'courseAttendees'));
    }


    public function survey(CourseAttendee $courseAttendee)
    {
        if ($courseAttendee->user_id != auth()->user()->id) {
            abort(403, 'You can\'t fill out this survey');
        }

        return view('site.dashboard.conferences.survey', compact('courseAttendee'));
    }

    public function surveyPost(Request $request, CourseAttendee $courseAttendee)
    {
        $survey = new SurveyConferenceCourseSubmission();
        $survey->course_id = $courseAttendee->course->id;
        $survey->user_id = auth()->user()->id;
        $survey->course_attendee_id = $courseAttendee->id;
        $survey->save();

        $line = new SurveyConferenceCourseLine();
        $line->num = 1;
        $line->question = $request->q1;
        $line->answer = $request->a1;
        $survey->lines()->save($line);

        $line = new SurveyConferenceCourseLine();
        $line->num = 2;
        $line->question = $request->q2;
        $line->answer = $request->a2;
        $survey->lines()->save($line);

        $line = new SurveyConferenceCourseLine();
        $line->num = 3;
        $line->question = $request->q3;
        $line->answer = $request->a3;
        $survey->lines()->save($line);

        if ($request->comments) {
            $line = new SurveyConferenceCourseLine();
            $line->num = 4;
            $line->question = 'Comments';
            $line->answer = $request->comments;
            $survey->lines()->save($line);
        }

        return redirect()->route('dashboard.conferences.show', $courseAttendee->conferenceAttendee)->with('success', 'Thank you for submitting the survey. Now you can get your certificate.');
    }

    public function certificate(CourseAttendee $courseAttendee)
    {

        // TODO: not restrictive enough 
        if (!auth()->user()->can('organization-admin')) {
            if ($courseAttendee->user_id != auth()->user()->id) {
                abort(403, 'This isn\'t yours');
            }
        }
        // return view('pdfs.conference-course-certificate', compact('courseAttendee'));

        // dd($courseAttendee);
        $pdf = Pdf::loadView('pdfs.conference-course-certificate', compact('courseAttendee'))->setPaper('letter', 'landscape')->set_option('dpi', '200');
        $file = Str::slug($courseAttendee->course->name . '-' . $courseAttendee->course->start_date->format('m-d-Y') . '-certificate') . '.pdf';

        return $pdf->download($file);
    }
}
