<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Course;
use App\Models\CourseTag;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\SurveyConferenceCourseLine;
use App\Models\SurveyConferenceCourseSubmission;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        // $courses = Course::orderBy('start_date')->get();
        return view('courses.index', compact('conference'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Conference $conference)
    {
        $instructors = User::role('Conference Instructor')->orderBy('name')->pluck('name', 'id');

        $venues = Venue::orderBy('name')->pluck('name', 'id');

        $parentCourses = Course::where('conference_id', $conference->id)
            ->where('link_id', null)
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('courses.create', compact('conference', 'instructors', 'venues', 'parentCourses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Conference $conference)
    {
        $course = new Course();
        $course->conference_id = $conference->id;
        $course->name = $request->name;
        $course->user_id = $request->user_id;
        $course->venue_id = $request->venue_id;
        $course->location = $request->location;
        $course->capacity = $request->capacity;
        $course->link_id = $request->link_id;
        $course->start_date = $request->start_date . ' ' . $request->start_time;
        $course->end_date = $request->end_date . ' ' . $request->end_time;
        $course->description = $request->description;
        $course->requirements = $request->requirements;
        $course->instructor_requests = $request->instructor_requests;
        $course->save();

        return redirect()->route('admin.courses.edit', [$course->conference, $course])->with('success', 'Course Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference, Course $course)
    {

        $answers = SurveyConferenceCourseLine::whereHas(
            'surveyConferenceCourseSubmission',
            function ($query) use ($course) {
                $query->where('course_id', $course->id);
            }
        )
            ->get()
            ->groupBy('question');


        return view('courses.show', compact('course', 'answers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, Course $course)
    {
        $instructors = User::role('Conference Instructor')->orderBy('name')->pluck('name', 'id');

        $venues = Venue::orderBy('name')->pluck('name', 'id');

        $parentCourses = Course::where('conference_id', $course->conference->id)
            ->where('link_id', null)
            ->where('id', '!=', $course->id)
            ->orderBy('name')
            ->pluck('name', 'id');

        $courseTags = CourseTag::orderBy('name')->get();

        return view('courses.edit', compact('conference', 'course', 'instructors', 'venues', 'parentCourses', 'courseTags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, Course $course)
    {
        $course->name = $request->name;
        $course->user_id = $request->user_id;
        $course->venue_id = $request->venue_id;
        $course->location = $request->location;
        $course->capacity = $request->capacity;
        $course->restricted = $request->restricted;
        $course->link_id = $request->link_id;
        $course->start_date = $request->start_date . ' ' . $request->start_time;
        $course->end_date = $request->end_date . ' ' . $request->end_time;
        $course->description = $request->description;
        $course->requirements = $request->requirements;
        $course->instructor_requests = $request->instructor_requests;

        $course->filled = $course->courseAttendees->count();
        $course->available = $course->capacity - $course->filled;

        $course->update();


        if ($request->user_ids) {
            $user_ids = array_filter($request->user_ids);
            $course->users()->sync($user_ids);
        }

        $course_tag_ids = null;
        if ($request->course_tag_ids) {
            $course_tag_ids = array_filter($request->course_tag_ids);
        }
        $course->courseTags()->sync($course_tag_ids);

        return redirect()->route('admin.courses.show', [$conference, $course])->with('success', 'Course Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, Course $course)
    {
        $course->courseAttendees->each->delete();
        $course->delete();

        return redirect()->route('admin.courses.index', $conference)
            ->with('success', 'Course deleted');
    }
}
