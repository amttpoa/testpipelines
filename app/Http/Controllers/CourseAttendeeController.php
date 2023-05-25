<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\EmailSent;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CourseAttendee;
use Barryvdh\DomPDF\Facade\Pdf;

class CourseAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference, Course $course)
    {
        $courseAttendees = CourseAttendee::where('course_id', $course->id)
            ->orderBy(
                User::select('name')->whereColumn('users.id', 'course_attendees.user_id')
            )
            // ->with('user', function ($q) {
            //     $q->orderBy('name');
            // })
            ->paginate(100);

        return view('course-attendees.index', compact('conference', 'course', 'courseAttendees'));
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
     * @param  \App\Models\CourseAttendee  $courseAttendee
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference, Course $course, CourseAttendee $courseAttendee)
    {
        return view('course-attendees.show', compact('conference', 'course', 'courseAttendee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseAttendee  $courseAttendee
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseAttendee $courseAttendee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseAttendee  $courseAttendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, Course $course, CourseAttendee $courseAttendee)
    {
        $courseAttendee->checked_in = $request->checked_in;
        $courseAttendee->completed = $request->completed;
        $courseAttendee->save();

        return back()->with('success', 'Course Attendee Updated');
    }

    public function updateBatch(Request $request, Conference $conference, Course $course)
    {
        if ($request->attendee_id) {
            if ($request->type == 'checkedin') {
                CourseAttendee::whereIn('id', $request->attendee_id)->update(['checked_in' => true]);
            }
            if ($request->type == 'completed') {
                CourseAttendee::whereIn('id', $request->attendee_id)->update(['completed' => true]);
            }
        }

        return back()->with('success', 'Attendees updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseAttendee  $courseAttendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, Course $course, CourseAttendee $courseAttendee)
    {
        $courseAttendee->delete();

        $courseAttendee->course->filled = $courseAttendee->course->courseAttendees->count();
        $courseAttendee->course->available = $courseAttendee->course->capacity - $course->filled;

        return redirect()->route('admin.course-attendees.index', [$conference, $course])
            ->with('success', 'Attendee deleted');
    }


    public function viewRoster(Conference $conference, Course $course)
    {
        $courses = Course::where('id', $course->id)->get();
        return view('course-attendees.print-roster', compact('courses'));
    }
    public function pdfRoster(Conference $conference, Course $course)
    {
        $courses = Course::where('id', $course->id)->get();
        $pdf = Pdf::loadView('course-attendees.print-roster', compact('courses'));
        $file = Str::slug($course->name . ' - roster') . '.pdf';

        return $pdf->download($file);
    }
    public function rosters(Conference $conference, Request $request)
    {
        if ($request->item == 'View Rosters') {
            $courses = Course::whereIn('id', $request->course_id)->orderBy('name')->get();
            return view('course-attendees.print-roster', compact('courses'));
        }
        if ($request->item == 'PDF Rosters') {
            $courses = Course::whereIn('id', $request->course_id)->orderBy('name')->get();
            $pdf = Pdf::loadView('course-attendees.print-roster', compact('courses'));
            $file = Str::slug('attendee-rosters') . '.pdf';

            return $pdf->download($file);
        }
    }
}
