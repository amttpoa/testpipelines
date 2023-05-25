<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendOneEmailJob;
use App\Models\EmailTemplate;
use App\Models\TrainingCourse;
use App\Models\TrainingCourseAttendee;

class StaffTrainingCourseAttendeeController extends Controller
{



    public function updateBatch(Request $request, TrainingCourse $trainingCourse)
    {
        if ($request->attendee_id) {
            if ($request->type == 'checkedin') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['checked_in' => true]);
            }
            if ($request->type == 'completed') {
                $attendees = TrainingCourseAttendee::whereIn('id', $request->attendee_id)->get();
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['completed' => true]);
                // dd($attendees);
                $template = EmailTemplate::where('code', 'training-complete')->first();
                $subject = $template->subject;

                $body = $template->body;
                $body = str_replace('[COURSE_NAME]', $trainingCourse->training->name, $body);
                $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

                foreach ($attendees as $attendee) {
                    $name = $attendee->user->name;
                    $email = $attendee->user->email;
                    $job = new SendOneEmailJob($name, $email, $subject, $body);
                    dispatch($job);
                }
            }
        }

        return back()->with('success', 'Attendees updated');
    }

    public function sendEmails(Request $request, TrainingCourse $trainingCourse)
    {
        $subject = $request->subject;
        $message = nl2br($request->message);

        foreach ($request->attendee_id as $attendee_id) {
            $attendee = TrainingCourseAttendee::find($attendee_id);


            $name = $attendee->user->name;
            $email = $attendee->user->email;
            // return response()->json($email);
            // $email_body = $message;
            // return view('emails.simple', compact('name', 'email_body'));
            $job = new SendOneEmailJob($name, $email, $subject, $message);
            dispatch($job);
        }


        // return back()->with('success', 'Attendees updated');
        return response()->json(['something' => 'thing']);
    }
    public function email(Request $request, TrainingCourse $trainingCourse)
    {
        $name = "test";
        $email_body = "testing";

        $attendee = TrainingCourseAttendee::find(13);

        $user = $attendee->user;

        $name = $attendee->user->name;
        $email = $attendee->user->email;
        // return response()->json($email);
        $message = "Stuff";
        $subject = "testing";

        $job = new SendOneEmailJob($name, $email, $subject, $message);
        // dd($job);
        dispatch($job);

        return view('emails.simple', compact('user', 'name', 'email_body'));

        // return view('emails.simple', compact('name', 'email_body'));
    }
}
