<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TrainingCourseAttendee;
use App\Models\SurveyTrainingCourseLine;
use App\Models\SurveyTrainingCourseSubmission;

class DashboardTrainingController extends Controller
{

    public function index()
    {
        $trainingCourses = TrainingCourse::whereHas('attendees', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })
            ->orderBy('start_date', 'DESC')
            ->get();

        $trainingCourseAttendees = TrainingCourseAttendee::where('user_id', auth()->user()->id)
            ->whereHas('trainingCourse')
            // ->orderBy('start_date')
            ->get()->sortByDesc('trainingCourse.start_date');

        // $trainingCourseAttendees = TrainingCourseAttendee::where('training_course_attendees.user_id', auth()->user()->id)->join('training_courses', 'training_course_attendees.training_course_id', '=', 'training_courses.id')
        //     ->orderBy('training_courses.start_date', 'DESC')
        //     ->get(['training_course_attendees.*']);

        // Post::with('user')->join('users', 'posts.user_id', '=', 'users.id')->orderBy('users.name')->get();


        // dd($trainingCourseAttendees);

        // $attendees = TrainingCourseAttendee::where('user_id', auth()->user)

        // dd($trainingCourses);
        return view('site.dashboard.trainings.index', compact('trainingCourses', 'trainingCourseAttendees'));
    }

    public function show(TrainingCourseAttendee $trainingCourseAttendee)
    {

        if ($trainingCourseAttendee->user_id != auth()->user()->id) {
            abort(403, 'Think you\'re clever, huh?');
        }
        // dd($trainingCourses);
        return view('site.dashboard.trainings.show', compact('trainingCourseAttendee'));
    }


    public function trainingSurvey(TrainingCourseAttendee $trainingCourseAttendee)
    {
        // dd($courseAttendee);
        return view('site.dashboard.trainings.survey', compact('trainingCourseAttendee'));
    }

    public function trainingSurveyPost(Request $request, TrainingCourseAttendee $trainingCourseAttendee)
    {
        $survey = new SurveyTrainingCourseSubmission();
        $survey->training_course_id = $trainingCourseAttendee->trainingCourse->id;
        $survey->user_id = auth()->user()->id;
        $survey->training_course_attendee_id = $trainingCourseAttendee->id;
        $survey->save();

        $line = new SurveyTrainingCourseLine();
        $line->num = 1;
        $line->question = $request->q1;
        $line->answer = $request->a1;
        $survey->lines()->save($line);

        $line = new SurveyTrainingCourseLine();
        $line->num = 2;
        $line->question = $request->q2;
        $line->answer = $request->a2;
        $survey->lines()->save($line);

        $line = new SurveyTrainingCourseLine();
        $line->num = 3;
        $line->question = $request->q3;
        $line->answer = $request->a3;
        $survey->lines()->save($line);

        if ($request->comments) {
            $line = new SurveyTrainingCourseLine();
            $line->num = 4;
            $line->question = 'Comments';
            $line->answer = $request->comments;
            $survey->lines()->save($line);
        }

        return redirect()->route('dashboard.trainings.show', $trainingCourseAttendee)->with('success', 'Thank you for submitting the survey. Now you can get your certificate.');
    }

    public function trainingCertificate(TrainingCourseAttendee $trainingCourseAttendee)
    {

        // return view('pdfs.conference-course-certificate', compact('courseAttendee'));

        // dd($trainingCourseAttendee);
        $pdf = Pdf::loadView('pdfs.training-course-certificate', compact('trainingCourseAttendee'))->setPaper('letter', 'landscape')->set_option('dpi', '200');
        $file = Str::slug($trainingCourseAttendee->user->name . '-' . $trainingCourseAttendee->trainingCourse->training->name . '-' . $trainingCourseAttendee->trainingCourse->end_date->format('m-d-Y') . '-certificate') . '.pdf';

        return $pdf->download($file);
    }
}
