<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use App\Models\TrainingWaitlist;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TrainingCourseAttendee;
use App\Exports\TrainingCourseAttendeesExport;

class TrainingCourseAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\TrainingCourseAttendee  $trainingCourseAttendee
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training, TrainingCourse $trainingCourse, TrainingCourseAttendee $trainingCourseAttendee)
    {
        return view('training-course-attendees.show', compact('training', 'trainingCourse', 'trainingCourseAttendee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingCourseAttendee  $trainingCourseAttendee
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training, TrainingCourse $trainingCourse, TrainingCourseAttendee $trainingCourseAttendee)
    {
        return view('training-course-attendees.edit', compact('training', 'trainingCourse', 'trainingCourseAttendee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainingCourseAttendee  $trainingCourseAttendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training, TrainingCourse $trainingCourse, TrainingCourseAttendee $trainingCourseAttendee)
    {
        $trainingCourseAttendee->comp = $request->comp;
        $trainingCourseAttendee->invoiced = $request->invoiced;
        $trainingCourseAttendee->paid = $request->paid;
        $trainingCourseAttendee->checked_in = $request->checked_in;
        $trainingCourseAttendee->completed = $request->completed;


        if ($request->has('pay_type')) {
            $trainingCourseAttendee->pay_type = $request->pay_type;
            $trainingCourseAttendee->total = $request->total;
            $trainingCourseAttendee->name = $request->name;
            $trainingCourseAttendee->email = $request->email;
        }
        $trainingCourseAttendee->update();


        return redirect()->route('admin.training-course-attendees.show', [$training, $trainingCourse, $trainingCourseAttendee])->with('success', 'Attendee Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingCourseAttendee  $trainingCourseAttendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training, TrainingCourse $trainingCourse, TrainingCourseAttendee $trainingCourseAttendee)
    {
        $trainingCourseAttendee->delete();
        return redirect()->route('admin.training-courses.show', [$training, $trainingCourse])->with('success', 'Attendee Deleted');
    }


    public function emailTest(TrainingCourseAttendee $trainingCourseAttendee)
    {

        $title = "Test Title";
        $content = "Test content";

        $subject = "Testing";

        $name = $trainingCourseAttendee->user->name;
        $email = "keethm@gmail.com";

        // $pdf = PDF::loadView('sequences.print', ['sequence' => $sequence, 'view' => 'pdf']);

        Mail::send('emails.test', compact('trainingCourseAttendee'), function ($message) use ($subject, $email) {
            $message->to($email);
            $message->subject($subject);
        });

        return "Email sent to " . $email;


        // $details = [
        //     'title' => 'Mail from sequence website test',
        //     'body' => 'This is for testing email using smtp'
        // ];

        // $email = $sequence->user->email;


        // Mail::to($email)->send(new sequenceMail($details));

        // dd("Email is Sent.");
        // return redirect()->back()->with('success', 'sequence email sent');
    }

    public function emailview(TrainingCourseAttendee $trainingCourseAttendee)
    {
        // dd($trainingCourseAttendee);
        return view('emails.test', compact('trainingCourseAttendee'));
    }

    public function addAttendee(Request $request, Training $training, TrainingCourse $trainingCourse)
    {
        if ($request->user_id > 0) {
            $trainingCourseAttendee = new TrainingCourseAttendee();
            $trainingCourseAttendee->training_course_id = $trainingCourse->id;
            $trainingCourseAttendee->user_id = $request->user_id;
            $trainingCourseAttendee->registered_by_user_id = auth()->user()->id;
            $trainingCourseAttendee->save();
            return back()->with('success', 'Attendee Added');
        } else {
            return back()->with('success', 'No User Selected');
        }
    }

    public function updateBatch(Request $request, Training $training, TrainingCourse $trainingCourse)
    {
        if ($request->attendee_id) {
            if ($request->item == 'full comp') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['comp' => $request->not ? 0 : 1]);
            }
            if ($request->item == 'invoiced') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['invoiced' => $request->not ? 0 : 1]);
            }
            if ($request->item == 'paid') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['paid' => $request->not ? 0 : 1]);
            }
            if ($request->item == 'checked in') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['checked_in' => $request->not ? 0 : 1]);
            }
            if ($request->item == 'completed') {
                TrainingCourseAttendee::whereIn('id', $request->attendee_id)->update(['completed' => $request->not ? 0 : 1]);
            }
            return back()->with('success', 'Attendees updated');
        }

        if ($request->waitlist_id) {
            foreach ($request->waitlist_id as $waitlist_id) {

                $waitlist = TrainingWaitlist::find($waitlist_id);
                $trainingCourseAttendee = new TrainingCourseAttendee();
                $trainingCourseAttendee->training_course_id = $waitlist->training_course_id;
                $trainingCourseAttendee->user_id = $waitlist->user_id;
                $trainingCourseAttendee->save();

                $waitlist->delete();
            }
            return back()->with('success', 'Users moved from waitlist to roster');
        }

        return back();
    }


    public function export(Training $training, TrainingCourse $trainingCourse)
    {
        // dd($trainingCourse);
        $file = $training->name . ' - ' . $trainingCourse->start_date->format('m-d-y') . ' - Attendees.xlsx';

        return Excel::download(new TrainingCourseAttendeesExport($trainingCourse), $file);
    }
}
