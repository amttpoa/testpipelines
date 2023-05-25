<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Conference;
use App\Models\CourseAttendee;
use Illuminate\Http\Request;

class StaffCourseAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference, Course $course)
    {
        if (!($course->user_id == auth()->user()->id || $course->users()->where('user_id', auth()->user()->id)->get()->isNotEmpty())) {
            abort(403, 'You\'re not teaching this course');
        }
        $attendees = $course->courseAttendees;
        return view('site.dashboard.staff.course-attendees.index', compact('conference', 'course', 'attendees'));
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
