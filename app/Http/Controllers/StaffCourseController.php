<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Conference;
use Illuminate\Http\Request;

class StaffCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        $courses = Course::where('user_id', auth()->user()->id)
            ->where('conference_id', $conference->id)
            ->orderBy('start_date')
            ->get();
        return view('site.dashboard.staff.courses.index', compact('conference', 'courses'));
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
    public function show(Conference $conference, Course $course)
    {
        if (!($course->user_id == auth()->user()->id || $course->users()->where('user_id', auth()->user()->id)->get()->isNotEmpty())) {
            abort(403, 'You\'re not teaching this course');
        }
        return view('site.dashboard.staff.courses.show', compact('conference', 'course'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, Course $course)
    {
        if (!($course->user_id == auth()->user()->id || $course->users()->where('user_id', auth()->user()->id)->get()->isNotEmpty())) {
            abort(403, 'You\'re not teaching this course');
        }
        return view('site.dashboard.staff.courses.edit', compact('conference', 'course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, Course $course)
    {
        $course->instructor_requests = $request->instructor_requests;
        $course->description = $request->description;
        $course->requirements = $request->requirements;
        $course->update();

        return redirect()->route('dashboard.staff.courses.edit', [$conference, $course])->with('success', 'Course Updated');
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
