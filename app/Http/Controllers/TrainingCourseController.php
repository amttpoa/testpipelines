<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;

class TrainingCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Training $training)
    {
        $courses = TrainingCourse::where('training_id', $training->id)->orderBy('start_date', 'DESC')->paginate(50);
        return view('training-courses.index', compact('training', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Training $training)
    {
        $trainings = Training::orderBy('order')->pluck('name', 'id');
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $instructors = User::role('Staff Instructor')->orderBy('name')->pluck('name', 'id');
        return view('training-courses.create', compact('training', 'trainings', 'venues', 'instructors'));
    }
    public function createTraining(Training $training)
    {
        $trainings = Training::orderBy('order')->pluck('name', 'id');
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $instructors = User::role('Staff Instructor')->orderBy('name')->pluck('name', 'id');
        return view('training-courses.create', compact('training', 'trainings', 'venues', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Training $training)
    {
        $course = new TrainingCourse();
        $course->training_id = $training->id;
        $course->user_id = $request->user_id;
        $course->venue_id = $request->venue_id;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->capacity = $request->capacity;
        $course->price = $request->price;
        $course->description = $request->description;
        $course->visible = $request->visible == 'true' ? 1 : 0;
        $course->active = $request->active == 'true' ? 1 : 0;
        $course->save();

        return redirect()->route('admin.training-courses.index', $training)->with('success', 'Training Course Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingCourse  $trainingCourse
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training, TrainingCourse $trainingCourse)
    {
        return view('training-courses.show', compact('training', 'trainingCourse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingCourse  $trainingCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training, TrainingCourse $trainingCourse)
    {
        // dd($trainingCourse);
        $trainings = Training::orderBy('order')->pluck('name', 'id');
        $venues = Venue::orderBy('name')->pluck('name', 'id');
        $instructors = User::role('Staff Instructor')->orderBy('name')->pluck('name', 'id');
        return view('training-courses.edit', compact('training', 'trainingCourse', 'trainings', 'venues', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training, TrainingCourse $trainingCourse)
    {
        // dd($request->user_ids);
        // dd($trainingCourse);
        $trainingCourse->user_id = $request->user_id;
        $trainingCourse->venue_id = $request->venue_id;
        $trainingCourse->start_date = $request->start_date;
        $trainingCourse->end_date = $request->end_date;
        $trainingCourse->capacity = $request->capacity;
        $trainingCourse->price = $request->price;
        $trainingCourse->description = $request->description;
        $trainingCourse->visible = $request->visible == 'true' ? 1 : 0;
        $trainingCourse->active = $request->active == 'true' ? 1 : 0;
        $trainingCourse->active_admin = $request->active_admin == 'true' ? 1 : 0;
        $trainingCourse->update();


        if ($request->user_ids) {
            $user_ids = array_filter($request->user_ids);
            $trainingCourse->users()->sync($user_ids);
        }

        return redirect()->route('admin.training-courses.index', $training)->with('success', 'Training Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingCourse  $trainingCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training, TrainingCourse $trainingCourse)
    {
        $trainingCourse->delete();
        return redirect()->route('admin.training-courses.index', $training)->with('success', 'Training course deleted');
    }

    public function showInstructor(TrainingCourse $trainingCourse)
    {
        // dd($trainingCourse);
        return view('site.training-course-instructor', compact('trainingCourse'));
    }
}
