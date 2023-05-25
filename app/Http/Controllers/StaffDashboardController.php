<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;

class StaffDashboardController extends Controller
{

    public function indexCourses()
    {
        return view('site.dashboard.staff.courses.index');
    }
    public function showCourses(Course $course)
    {
        return view('site.dashboard.staff.courses.show', compact('course'));
    }
    public function editCourses(Course $course)
    {
        return view('site.dashboard.staff.courses.edit', compact('course'));
    }

    public function updateCourses(Request $request, Course $course)
    {
        // $course->description = $request->description;
        // $course->requirements = $request->requirements;
        // $course->update();

        // return redirect()->route('dashboard.staff.courses.edit', $course)->with('success', 'Course Updated');
    }

    public function rosterCourses(Course $course)
    {
        return view('site.dashboard.staff.courses.roster', compact('course'));
    }


    public function indexTrainings()
    {
        // $courses = TrainingCourse::where('user_id', auth()->user()->id)
        //     ->orderBy('start_date',)
        //     ->get()
        //     ->groupBy(function ($e) {
        //         return $e->training->name;
        //     });

        $courses = TrainingCourse::where('user_id', auth()->user()->id)
            ->orWhereHas('users', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })
            ->orderBy('start_date', 'DESC')
            ->get();
        // dd($courses);


        return view('site.dashboard.staff.trainings.index', compact('courses'));
    }
    public function showTrainingCourses(TrainingCourse $trainingCourse)
    {
        // dd($trainingCourse->users()->where('user_id', auth()->user()->id)->get());
        if ($trainingCourse->user_id != auth()->user()->id) {
            if ($trainingCourse->users()->where('user_id', auth()->user()->id)->get()->isEmpty()) {
                abort(403, 'You\'re not teaching this course');
            }
        }
        return view('site.dashboard.staff.training-courses.show', compact('trainingCourse'));
    }

    public function signatureGenerator()
    {
        return view('site.dashboard.staff.signature-generator');
    }
    public function signatureGeneratorFrame()
    {
        return view('site.dashboard.staff.signature-generator-frame');
    }
}
