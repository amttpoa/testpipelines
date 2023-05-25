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
use App\Jobs\SendConferenceEmail;
use App\Models\ConferenceAttendee;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ConferenceAttendeeExport;
use App\Jobs\SendConferenceInstructorEmailJob;

class ConferenceAttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        return view('conference-attendees.index', compact('conference'));
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
     * @param  \App\Models\ConferenceAttendee  $conferenceAttendee
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        return view('conference-attendees.show', compact('conferenceAttendee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConferenceAttendee  $conferenceAttendee
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $courses = Course::where('conference_id', $conference->id)
            ->with('parent')
            ->with('children')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->with('venue:id,name,address,city,state,zip,slug')
            ->with('courseTags')
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($date) {
                return $date->start_date->format('l, F j, Y');
            });
        // dd($courses);
        foreach ($courses as $day) {
            foreach ($day as $course) {
                $course->date_display = $course->start_date->format('l, F j, Y');
                $course->start_time = $course->start_date->format('H:i');
                $course->end_time = $course->end_date->format('H:i');
                $course->filled = $course->courseAttendees->count();
                $course->closed = ($course->courseAttendees->count() >= $course->capacity) ? true : false;
                $course->disabled = $course->closed;
                $course->instructor_image = '';
            }
        }
        return view('conference-attendees.edit', compact('conferenceAttendee', 'courses', 'conference'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConferenceAttendee  $conferenceAttendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $conferenceAttendee->comp = $request->comp;
        $conferenceAttendee->invoiced = $request->invoiced;
        $conferenceAttendee->paid = $request->paid;
        $conferenceAttendee->checked_in = $request->checked_in;
        $conferenceAttendee->completed = $request->completed;

        $conferenceAttendee->save();

        if ($request->has('package')) {

            $conferenceAttendee->package = $request->package;
            $conferenceAttendee->total = $request->total;
            $conferenceAttendee->name = $request->name;
            $conferenceAttendee->email = $request->email;
            $conferenceAttendee->card_first_name = $request->card_first_name;
            $conferenceAttendee->card_last_name = $request->card_last_name;
            $conferenceAttendee->card_type = $request->card_type;
            $conferenceAttendee->save();


            $course_ids = $request->course_ids;
            // dd($course_ids);
            $attendees = CourseAttendee::where('conference_attendee_id', $conferenceAttendee->id)
                ->where('user_id', $conferenceAttendee->user_id)
                ->when($course_ids, function ($query) use ($course_ids) {
                    $query->whereNotIn('course_id', $course_ids);
                })
                // ->whereNotIn('course_id', $request->course_ids)
                ->get();
            $attendees->each->delete();

            if ($request->course_ids) {
                foreach ($request->course_ids as $course_id) {

                    $courseAttendee = CourseAttendee::where('course_id', $course_id)
                        ->where('conference_attendee_id', $conferenceAttendee->id)
                        ->where('user_id', $conferenceAttendee->user_id)
                        ->first();
                    if (!$courseAttendee) {
                        $courseAttendee = new CourseAttendee;
                        $courseAttendee->course_id = $course_id;
                        $courseAttendee->user_id = $conferenceAttendee->user_id;
                        $conferenceAttendee->courseAttendees()->save($courseAttendee);
                    }
                }
            }
        }

        return back()->with('success', 'Conference Attendee Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConferenceAttendee  $conferenceAttendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $conferenceAttendee->delete();
        // $conferenceAttendee->courseAttendees()->delete();
        $conferenceAttendee->courseAttendees->each->delete();
        return redirect()->route('admin.conference-attendees.index', $conferenceAttendee->conference)
            ->with('success', 'Attendee deleted');
    }

    public function emailRegisteredAttendee(ConferenceAttendee $conferenceAttendee)
    {

        $title = "Test Title";
        $content = "Test content";

        $subject = "You have been registered for the " . $conferenceAttendee->conference->name;

        $name = $conferenceAttendee->user->name;
        $email = "keethm@gmail.com";

        // $pdf = PDF::loadView('sequences.print', ['sequence' => $sequence, 'view' => 'pdf']);

        Mail::send('emails.conference-registered', compact('conferenceAttendee'), function ($message) use ($subject, $email) {
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

    public function emailRegisteredAttendeeView(ConferenceAttendee $conferenceAttendee)
    {
        // dd($trainingCourseAttendee);
        return view('emails.conference-registered', compact('conferenceAttendee'));
    }


    public function export(Request $request, Conference $conference)
    {
        $file = $conference->name . ' - Attendees.xlsx';

        return Excel::download(new ConferenceAttendeeExport($request, $conference), $file);
    }

    public function sendEmails(Request $request, Conference $conference)
    {
        $tos = [
            'All Conference Attendees' => 'All ' . $conference->conferenceAttendees->count() . ' Conference Attendees',
            'All Course Instructors' => 'All Course Instructors',
            'Test to Pat' => 'Test to Pat',
        ];
        $sent = EmailSent::where('subject_type', 'App\Models\ConferenceAttendee')
            ->where('subject_id', $conference->id)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('conference-attendees.send-emails', compact('conference', 'tos', 'sent'));
    }

    public function sendEmailsView(Request $request, Conference $conference)
    {
        $attendee = $conference->conferenceAttendees->first();
        $email_body = "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi alias quasi voluptas adipisci recusandae, soluta repellat maxime vitae eveniet quod? Quisquam alias sint, repudiandae totam expedita atque vero sed maxime. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nostrum dicta ratione nulla quasi nemo repudiandae odio omnis voluptate, doloribus hic atque non minima, minus explicabo quisquam molestias quae consequatur beatae.</p>";
        return view('emails.conference-schedule', compact('attendee', 'email_body'));
    }

    public function sendEmailsPost(Request $request, Conference $conference)
    {
        $to = $request->to;
        $subject = $request->subject;
        $message = $request->message;
        $count = 0;

        if ($to == 'All Conference Attendees') {
            foreach ($conference->conferenceAttendees as $attendee) {
                $job = new SendConferenceEmail($attendee, $subject, $message);
                dispatch($job);
                $count++;
            }
        }
        if ($to == 'All Course Instructors') {
            // $users = User::whereHas('courses', function ($query) use ($conference) {
            //     $query->where('conference_id', $conference->id);
            // })
            //     ->orWhereHas('subCourses', function ($query) use ($conference) {
            //         $query->where('conference_id', $conference->id);
            //     })
            //     ->get();
            $users = User::teachingCoursesFor($conference)->get();

            // dd($users);
            foreach ($users as $user) {

                // dd($user->conferenceCoursesTeaching($conference));

                $job = new SendConferenceInstructorEmailJob($conference, $user, $subject, $message);
                dispatch($job);
                $count++;
            }
        }
        if ($to == 'Test to Pat') {
            $attendee = ConferenceAttendee::where('conference_id', $conference->id)->where('user_id', 2)->first();
            $job = new SendConferenceEmail($attendee, $subject, $message);
            dispatch($job);
            $count++;
        }

        $sent = new EmailSent();
        $sent->subject_type = "App\Models\ConferenceAttendee";
        $sent->subject_id = $conference->id;
        $sent->to = $to;
        $sent->subject = $subject;
        $sent->message = $message;
        $sent->sent = $count;
        $sent->save();

        return redirect()->back()->with('success', 'Conference emails sent');
    }


    public function addAttendee(Request $request, Conference $conference)
    {
        if ($request->user_id > 0) {
            $conferenceAttendee = new ConferenceAttendee();
            $conferenceAttendee->conference_id = $conference->id;
            $conferenceAttendee->user_id = $request->user_id;
            $conferenceAttendee->registered_by_user_id = auth()->user()->id;
            $conferenceAttendee->save();
            return back()->with('success', 'Attendee Added');
        } else {
            return back()->with('success', 'No User Selected');
        }
    }

    public function fillBadges(Conference $conference)
    {
        // dd($trainingCourseAttendee);
        $attendees = ConferenceAttendee::where('conference_id', $conference->id)
            ->whereNull('card_first_name')
            ->whereNull('card_last_name')
            ->whereNull('card_type')
            ->get();
        foreach ($attendees as $attendee) {
            $attendeeArray = explode(' ', $attendee->user->name);
            $card_first_name = $attendeeArray[0];
            array_shift($attendeeArray);
            // if (count($attendeeArray)) {
            $card_last_name = implode(' ', $attendeeArray);
            // }
            $attendee->card_first_name = $card_first_name;
            $attendee->card_last_name = $card_last_name;
            $attendee->card_type = 'Attendee';
            if ($attendee->user->can('conference-instructor')) {
                $attendee->card_type = 'Instructor';
            }
            if ($attendee->user->can('staff')) {
                $attendee->card_type = 'Staff';
            }
            $attendee->update();
        }
        return back()->with('success', $attendees->count() . ' Badges filled in');
    }

    public function badge(Conference $conference)
    {
        return view('conference-attendees.badge', compact('conference'));
    }
    public function badgePost(Conference $conference, Request $request)
    {
        // dd($request->item);
        $badge = new ConferenceAttendee;
        $badge->card_first_name = $request->card_first_name;
        $badge->card_last_name = $request->card_last_name;
        $badge->card_organization = $request->card_organization;
        $badge->card_package = $request->card_package;
        $badge->card_type = $request->card_type;
        $badges = collect([$badge]);
        // dd($badges);
        if ($request->item == 'View Badge') {
            $view = 'html';
            // $badges = ConferenceAttendee::whereIn('id', $request->attendee_id)->get();
            return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
        }
        if ($request->item == 'PDF Badge') {
            $view = 'pdf';
            $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))
                ->setPaper([0.0, 0.0, 288.00, 432.00]);
            // ->set_option('dpi', '200');
            $file = Str::slug('attendee-badges') . '.pdf';

            return $pdf->download($file);
        }
    }


    public function viewBadge(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $view = 'html';
        $badges = ConferenceAttendee::where('id', $conferenceAttendee->id)->get();
        return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
    }
    public function pdfBadge(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $view = 'pdf';
        $badges = ConferenceAttendee::where('id', $conferenceAttendee->id)->get();
        $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))->setPaper([0.0, 0.0, 288.00, 432.00]);
        $file = Str::slug($conferenceAttendee->user->name . '-badge') . '.pdf';

        return $pdf->download($file);
    }


    public function viewBadges(Conference $conference)
    {
        $view = 'html';
        $badges = ConferenceAttendee::where('conference_id', $conference->id)
            ->orderBy('card_type')
            ->orderBy('card_last_name')
            ->get();
        return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
    }
    public function pdfBadges(Conference $conference)
    {
        $view = 'pdf';
        $badges = ConferenceAttendee::where('conference_id', $conference->id)
            ->where('card_type', 'Staff')
            ->orderBy('card_type')
            ->orderBy('card_last_name')
            ->get();
        $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))->setPaper([0.0, 0.0, 288.00, 432.00]);
        $file = Str::slug('attendee-badges') . '.pdf';

        return $pdf->download($file);
    }


    public function badges(Conference $conference, Request $request)
    {
        // dd($request->item);
        if ($request->item == 'View Badges') {
            $view = 'html';
            $badges = ConferenceAttendee::whereIn('id', $request->attendee_id)
                ->orderBy('card_last_name')
                ->get();
            return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
        }
        if ($request->item == 'PDF Badges') {
            $view = 'pdf';
            $badges = ConferenceAttendee::whereIn('id', $request->attendee_id)
                ->orderBy('card_last_name')
                ->get();
            $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))
                ->setPaper([0.0, 0.0, 288.00, 432.00]);
            // ->set_option('dpi', '200');
            $file = Str::slug('attendee-badges') . '.pdf';

            return $pdf->download($file);
        }
    }
}
