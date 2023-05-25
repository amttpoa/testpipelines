<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Radio;
use App\Models\EmailSent;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Exports\VendorsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\SendVendorEmailJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Models\VendorRegistrationNote;
use Illuminate\Support\Facades\Storage;
use App\Models\VendorRegistrationAttendee;
use App\Models\VendorRegistrationSubmission;

class VendorRegistrationSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conference $conference)
    {
        // @dd($conference);

        $submissions = VendorRegistrationSubmission::where('conference_id', $conference->id)->orderBy('created_at', 'DESC')->get();
        // $attendees = VendorRegistrationAttendee::with('submission')->where('submission'get();
        $attendees = VendorRegistrationAttendee::whereIn('vendor_registration_submission_id', function ($query) use ($conference) {
            $query->select(DB::raw('id'))
                ->from('vendor_registration_submissions')
                ->where('conference_id', $conference->id)
                ->where('deleted_at', null);
        })
            ->get();
        // This will produce:
        // $attendees = VendorRegistrationAttendee::with(['submission' => function($q) {
        //     $q->select('id', 'name');
        //     $q->where('available', '=', 1);
        // }])                    
        // ->get();
        // return $result;
        // dd($attendees);
        return view('vendor-registrations.index', compact('conference', 'submissions', 'attendees'));
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
     * @param  \App\Models\VendorRegistrationSubmission  $vendorRegistrationSubmission
     * @return \Illuminate\Http\Response
     */
    public function show(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd($vendorRegistrationSubmission);
        $vendorNotes = VendorRegistrationNote::where('vendor_registration_submission_id', $vendorRegistrationSubmission->id)
            ->orderBy('created_at')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->get();

        $vendorNotes = $vendorNotes
            ->map(function ($item) {
                $item->created_at_formatted = $item->created_at->format('F jS Y h:i A') . ' (' . $item->created_at->diffForHumans() . ')';
                $item->user_image = Storage::disk('s3')->url('profiles/' . ($item->user->profile->image ? $item->user->profile->image : 'no-image.png'));
                return $item;
            });

        return view('vendor-registrations.show', compact('conference', 'vendorRegistrationSubmission', 'vendorNotes'));
    }

    public function print(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd($vendorRegistrationSubmission);
        return view('vendor-registrations.print', compact('conference', 'vendorRegistrationSubmission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VendorRegistrationSubmission  $vendorRegistrationSubmission
     * @return \Illuminate\Http\Response
     */
    public function edit(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {

        // dd($vendorRegistrationSubmission);
        $vendorNotes = VendorRegistrationNote::where('vendor_registration_submission_id', $vendorRegistrationSubmission->id)
            ->orderBy('created_at')
            ->with('user:id,name')
            ->with('user.profile:id,user_id,image')
            ->get();

        $vendorNotes = $vendorNotes
            ->map(function ($item) {
                $item->created_at_formatted = $item->created_at->format('F jS Y h:i A') . ' (' . $item->created_at->diffForHumans() . ')';
                $item->user_image = Storage::disk('s3')->url('profiles/' . ($item->user->profile->image ? $item->user->profile->image : 'no-image.png'));
                return $item;
            });

        $sponsorships = Radio::where('field', 'sponsorship')->orderBy('order')->pluck('value', 'value');

        return view('vendor-registrations.edit', compact('conference', 'vendorRegistrationSubmission', 'vendorNotes', 'sponsorships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VendorRegistrationSubmission  $vendorRegistrationSubmission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd($request->sponsorship);
        if ($request->sponsorship) {
            $vendorRegistrationSubmission->sponsorship = $request->sponsorship;
            $vendorRegistrationSubmission->sponsorship_price = $request->sponsorship_price;
            $vendorRegistrationSubmission->live_fire = $request->live_fire;
            $vendorRegistrationSubmission->live_fire_price = $request->live_fire_price;
            $vendorRegistrationSubmission->lunch = $request->lunch;
            $vendorRegistrationSubmission->lunch_price = $request->lunch_price;
            $vendorRegistrationSubmission->power = $request->power;
            $vendorRegistrationSubmission->power_price = $request->power_price;
            $vendorRegistrationSubmission->tv = $request->tv;
            $vendorRegistrationSubmission->tv_price = $request->tv_price;
            $vendorRegistrationSubmission->internet = $request->internet;
            $vendorRegistrationSubmission->internet_price = $request->internet_price;
            $vendorRegistrationSubmission->tables = $request->tables;
            $vendorRegistrationSubmission->tables_price = $request->tables_price;

            $vendorRegistrationSubmission->advertising_name = $request->advertising_name;
            $vendorRegistrationSubmission->advertising_email = $request->advertising_email;
            $vendorRegistrationSubmission->advertising_phone = $request->advertising_phone;
            $vendorRegistrationSubmission->live_fire_name = $request->live_fire_name;
            $vendorRegistrationSubmission->live_fire_email = $request->live_fire_email;
            $vendorRegistrationSubmission->live_fire_phone = $request->live_fire_phone;
            $vendorRegistrationSubmission->billing_name = $request->billing_name;
            $vendorRegistrationSubmission->billing_email = $request->billing_email;
            $vendorRegistrationSubmission->billing_phone = $request->billing_phone;

            $vendorRegistrationSubmission->total = $request->total;
            $vendorRegistrationSubmission->lunch_qty = $request->lunch_qty;
            $vendorRegistrationSubmission->tables_qty = $request->tables_qty;

            $vendorRegistrationSubmission->update();

            if ($request->attendee_id) {
                foreach ($request->attendee_id as $key => $attendee_id) {
                    if ($request->attendee_id[$key]) {
                        $attendee = VendorRegistrationAttendee::find($request->attendee_id[$key]);
                        $attendee->name = $request->attendee_name[$key];
                        $attendee->email = $request->attendee_email[$key];
                        $attendee->phone = $request->attendee_phone[$key];
                        $attendee->card_first_name = $request->card_first_name[$key];
                        $attendee->card_last_name = $request->card_last_name[$key];
                        $attendee->card_type = $request->card_type[$key];
                        $attendee->update();
                    } else {
                        $attendee = new VendorRegistrationAttendee();
                        $attendee->name = $request->attendee_name[$key];
                        $attendee->email = $request->attendee_email[$key];
                        $attendee->phone = $request->attendee_phone[$key];
                        $attendee->card_first_name = $request->card_first_name[$key];
                        $attendee->card_last_name = $request->card_last_name[$key];
                        $attendee->card_type = $request->card_type[$key];
                        $attendee->vendor_registration_submission_id = $vendorRegistrationSubmission->id;
                        $attendee->save();
                    }
                }
            }
            if ($request->delete) {
                VendorRegistrationAttendee::where('id', $request->delete)->delete();
            }
        } else {

            $vendorRegistrationSubmission->public = $request->public;
            $vendorRegistrationSubmission->invoiced = $request->invoiced;
            $vendorRegistrationSubmission->paid = $request->paid;
            $vendorRegistrationSubmission->advertising = $request->advertising;
            $vendorRegistrationSubmission->comp = $request->comp;
            $vendorRegistrationSubmission->checked_in = $request->checked_in;
            $vendorRegistrationSubmission->update();
        }

        return redirect()->route('admin.vendor-registration-submissions.show', [$vendorRegistrationSubmission->conference, $vendorRegistrationSubmission])->with('success', 'Submission updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VendorRegistrationSubmission  $vendorRegistrationSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {

        $vendorRegistrationSubmission->delete();
        return redirect()->route('admin.vendor-registration-submissions.index', $conference)
            ->with('success', 'Submission deleted');
    }

    public function sendEmails(Request $request, Conference $conference)
    {
        $tos = [
            'User Submitted' => 'User Submitted',
            'Advertising' => 'Advertising',
            'Live Fire' => 'Live Fire',
            'Representatives' => 'Representatives',
        ];
        $sent = EmailSent::where('subject_type', 'App\Models\VendorRegistrationSubmission')
            ->where('subject_id', $conference->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $vendors = null;
        if ($request->vendor_id) {
            $vendors = VendorRegistrationSubmission::whereIn('id', $request->vendor_id)
                ->get()->sortBy('organization.name');
        }
        return view('vendor-registrations.send-emails', compact('conference', 'tos', 'sent', 'request', 'vendors'));
    }

    public function sendEmailsView(Request $request, Conference $conference)
    {
        $vendor = $conference->vendors->first();
        $name = 'Tester Testing';
        $email = "keethm@gmail.com";
        // dd($attendee);
        $email_body = "<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi alias quasi voluptas adipisci recusandae, soluta repellat maxime vitae eveniet quod? Quisquam alias sint, repudiandae totam expedita atque vero sed maxime. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nostrum dicta ratione nulla quasi nemo repudiandae odio omnis voluptate, doloribus hic atque non minima, minus explicabo quisquam molestias quae consequatur beatae.</p>";
        return view('emails.conference-vendor', compact('name', 'email', 'vendor', 'email_body'));
    }

    public function sendEmailsPost(Request $request, Conference $conference)
    {
        $message = $request->message;
        $subject = $request->subject;
        $to = $request->to;
        $count = 0;

        if ($to == 'User Submitted') {
            foreach ($conference->vendors as $vendor) {
                if ($vendor->user) {
                    $name = $vendor->user->name;
                    $email = $vendor->user->email;
                    $job = new SendVendorEmailJob($name, $email, $vendor, $message, $subject);
                    dispatch($job);
                    $count++;
                }
            }
        }
        if ($to == 'Advertising') {
            foreach ($conference->vendors as $vendor) {
                $name = $vendor->advertising_name;
                $email = $vendor->advertising_email;
                if ($email) {
                    $job = new SendVendorEmailJob($name, $email, $vendor, $message, $subject);
                    dispatch($job);
                    $count++;
                }
            }
        }
        if ($to == 'Live Fire') {
            foreach ($conference->vendors as $vendor) {
                $name = $vendor->live_fire_name;
                $email = $vendor->live_fire_email;
                if ($email) {
                    $job = new SendVendorEmailJob($name, $email, $vendor, $message, $subject);
                    dispatch($job);
                    $count++;
                }
            }
        }
        if ($to == 'Representatives') {
            foreach ($conference->vendors as $vendor) {
                foreach ($vendor->attendees as $attendee) {
                    $name = $attendee->name;
                    $email = $attendee->email;
                    $job = new SendVendorEmailJob($name, $email, $vendor, $message, $subject);
                    dispatch($job);
                    $count++;
                }
            }
        }
        if ($request->vendor_id) {
            foreach (explode(',', $request->vendor_id) as $vendor_id) {
                $vendor = VendorRegistrationSubmission::find($vendor_id);
                $name = $vendor->user->name;
                $email = $vendor->user->email;
                $to = "Selected Users";
                if ($email) {
                    // dd($vendor->organization->name);
                    $job = new SendVendorEmailJob($name, $email, $vendor, $message, $subject);
                    dispatch($job);
                    $count++;
                }
            }
        }



        $sent = new EmailSent();
        $sent->subject_type = "App\Models\VendorRegistrationSubmission";
        $sent->subject_id = $conference->id;
        $sent->to = $to;
        $sent->subject = $subject;
        $sent->message = $message;
        $sent->sent = $count;
        $sent->save();

        return redirect()->back()->with('success', 'Vendor emails sent');
    }

    public function export(Request $request, Conference $conference)
    {
        // $status_id = $request->id;
        if ($request->type == 'attendees') {
            $file = $conference->name . ' - Vendor Representatives.xlsx';
        } else {
            $file = $conference->name . ' - Vendors.xlsx';
        }

        if ($request->view == 'web') {
            $type = $request->type;
            return view('vendor-registrations.export', compact('conference', 'type'));
        } else {
            return Excel::download(new VendorsExport($request, $conference), $file);
        }
    }


    public function emailTest()
    {
        $user = User::find(1);
        $name = $user->name;
        $submission = VendorRegistrationSubmission::find(27);
        // dd($submission);
        $email_body = '';
        return view('emails.vendor-rep', compact('name', 'email_body', 'submission'));
    }

    public function storenote(Request $request)
    {

        $vendorNote = new VendorRegistrationNote();
        $vendorNote->vendor_registration_submission_id = $request->input('submission_id');
        $vendorNote->user_id = auth()->user()->id;
        $vendorNote->note = $request->input('new_note');

        $vendorNote->save();


        // $vendorNotes = VendorRegistrationNote::where('id', $vendorNote->id)->with('user:id,name')->with('user.profile:id,user_id,image')->first();
        $vendorNote->created_at_formatted = $vendorNote->created_at->format('F jS Y h:i A') . ' (' . $vendorNote->created_at->diffForHumans() . ')';
        $vendorNote->user_image = Storage::disk('s3')->url('profiles/' . ($vendorNote->user->profile->image ? $vendorNote->user->profile->image : 'no-image.png'));

        return response()->json($vendorNote);
    }

    public function addBarter(Request $request, Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        $vendorRegistrationSubmission->barter()->create();

        $user = $vendorRegistrationSubmission->user;
        $email = $user->email;

        $template = EmailTemplate::where('code', 'barter-added')->first();
        $subject = $template->subject;

        $content = $template->body;
        $content = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $content);
        $content = str_replace('[COMPANY]', $vendorRegistrationSubmission->organization->name, $content);

        Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        return redirect()->back()->with('success', 'Barter Form Added');
    }
    public function updateBarter(Request $request, Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        $vendorRegistrationSubmission->barter()->update(['comments' => $request->comments]);
        return redirect()->back()->with('success', 'Barter Form Updated');
    }

    public function fillBadges(Conference $conference)
    {
        // dd($trainingCourseAttendee);
        $attendees = VendorRegistrationAttendee::whereIn(
            'vendor_registration_submission_id',
            VendorRegistrationSubmission::where('conference_id', $conference->id)->pluck('id')
        )
            ->whereNull('card_first_name')
            ->whereNull('card_last_name')
            ->whereNull('card_type')
            ->get();
        // dd($attendees);
        foreach ($attendees as $attendee) {
            $attendeeArray = explode(' ', $attendee->name);
            $card_first_name = $attendeeArray[0];
            array_shift($attendeeArray);
            // if (count($attendeeArray)) {
            $card_last_name = implode(' ', $attendeeArray);
            // }
            $attendee->card_first_name = $card_first_name;
            $attendee->card_last_name = $card_last_name;
            $attendee->card_type = 'Exhibitor';
            // if ($attendee->user->can('conference-instructor')) {
            //     $attendee->card_type = 'Instructor';
            // }
            // if ($attendee->user->can('staff')) {
            //     $attendee->card_type = 'Staff';
            // }
            $attendee->update();
        }
        return back()->with('success', $attendees->count() . ' Badges filled in');
    }


    public function viewBadge(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        $view = 'html';
        $badges = VendorRegistrationAttendee::where('vendor_registration_submission_id', $vendorRegistrationSubmission->id)->get();
        return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
    }
    public function pdfBadge(Conference $conference, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        $view = 'pdf';
        $badges = VendorRegistrationAttendee::where('vendor_registration_submission_id', $vendorRegistrationSubmission->id)->get();
        $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))->setPaper([0.0, 0.0, 288.00, 432.00]);
        $file = Str::slug('vendor-badges') . '.pdf';

        return $pdf->download($file);
    }
    public function viewBadges(Conference $conference)
    {
        $view = 'html';
        $badges = VendorRegistrationAttendee::whereIn(
            'vendor_registration_submission_id',
            VendorRegistrationSubmission::where('conference_id', $conference->id)->pluck('id')
        )
            // ->orderBy('card_last_name')
            ->get()
            ->sortBy('vendorRegistrationSubmission.organization.name');
        return view('conference-attendees.print-badge', compact('badges', 'view', 'conference'));
    }
    public function pdfBadges(Conference $conference)
    {
        $view = 'pdf';
        $badges = VendorRegistrationAttendee::whereIn(
            'vendor_registration_submission_id',
            VendorRegistrationSubmission::where('conference_id', $conference->id)->pluck('id')
        )
            // ->orderBy('card_last_name')
            ->get()
            ->sortBy('vendorRegistrationSubmission.organization.name');
        $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view', 'conference'))->setPaper([0.0, 0.0, 288.00, 432.00]);
        $file = Str::slug('vendor-badges') . '.pdf';

        return $pdf->download($file);
    }
    // public function badges(Conference $conference, Request $request)
    // {
    //     // dd($request->item);
    //     if ($request->item == 'View Badges') {
    //         $view = 'html';
    //         $badges = ConferenceAttendee::whereIn('id', $request->attendee_id)->get();
    //         return view('conference-attendees.print-badge', compact('badges', 'view'));
    //     }
    //     if ($request->item == 'PDF Badges') {
    //         $view = 'pdf';
    //         $badges = ConferenceAttendee::whereIn('id', $request->attendee_id)->get();
    //         $pdf = Pdf::loadView('conference-attendees.print-badge', compact('badges', 'view'))
    //             ->setPaper([0.0, 0.0, 288.00, 432.00]);
    //         // ->set_option('dpi', '200');
    //         $file = Str::slug('attendee-badges') . '.pdf';

    //         return $pdf->download($file);
    //     }
    // }
}
