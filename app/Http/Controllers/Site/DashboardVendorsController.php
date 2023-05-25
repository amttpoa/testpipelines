<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Models\Barter;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\LiveFireSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Jobs\SendVendorDefaultEmailJob;
use Illuminate\Support\Facades\Storage;
use App\Models\VendorRegistrationAttendee;
use App\Models\VendorRegistrationSubmission;

class DashboardVendorsController extends Controller
{
    public function editVendorRegistration(VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // $attendees = VendorRegistrationAttendee::where('vendor_registration_submission_id')->with('user:id')
        return view('site.dashboard.vendor-registrations.edit', compact('vendorRegistrationSubmission'));
    }
    public function updateVendorRegistration(Request $request, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd(explode(',', $request->delete));

        $vendorRegistrationSubmission->company_name = $request->company_name;
        $vendorRegistrationSubmission->company_website = $request->company_website;
        $vendorRegistrationSubmission->website_description = $request->website_description;

        if ($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $resize = Image::make($request->image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream()->detach();
            Storage::disk('s3')->put('vendor-logos/' . $newfileName, $resize);

            $vendorRegistrationSubmission->image = $newfileName;
        }
        $vendorRegistrationSubmission->update();

        if ($request->attendee_id) {
            foreach ($request->attendee_id as $key => $attendee_id) {
                if ($request->attendee_id[$key]) {
                    $attendee = VendorRegistrationAttendee::find($request->attendee_id[$key]);

                    if ($attendee->email != $request->attendee_email[$key]) {
                        $template = EmailTemplate::where('code', 'vendor-reps')->first();
                        $name = $request->attendee_name[$key];
                        $email = $request->attendee_email[$key];
                        $subject = $template->subject;

                        $body = $template->body;
                        $body = str_replace('[COMPANY]', $vendorRegistrationSubmission->organization->name, $body);
                        $body = str_replace('[CONFERENCE]', $vendorRegistrationSubmission->conference->name, $body);
                        $body = str_replace('[SUBMITTED_BY_USER]', auth()->user()->name, $body);

                        $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $vendorRegistrationSubmission);
                        dispatch($job);
                    }

                    $attendee->name = $request->attendee_name[$key];
                    $attendee->email = $request->attendee_email[$key];
                    $attendee->phone = $request->attendee_phone[$key];
                    $attendee->update();
                } else {
                    $attendee = new VendorRegistrationAttendee();
                    $attendee->name = $request->attendee_name[$key];
                    $attendee->email = $request->attendee_email[$key];
                    $attendee->phone = $request->attendee_phone[$key];
                    $attendee->vendor_registration_submission_id = $vendorRegistrationSubmission->id;
                    $attendee->save();

                    $template = EmailTemplate::where('code', 'vendor-reps')->first();
                    $name = $request->attendee_name[$key];
                    $email = $request->attendee_email[$key];
                    $subject = $template->subject;

                    $body = $template->body;
                    $body = str_replace('[COMPANY]', $vendorRegistrationSubmission->organization->name, $body);
                    $body = str_replace('[CONFERENCE]', $vendorRegistrationSubmission->conference->name, $body);
                    $body = str_replace('[SUBMITTED_BY_USER]', auth()->user()->name, $body);

                    $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $vendorRegistrationSubmission);
                    dispatch($job);
                }
            }
        }
        if ($request->delete) {
            foreach (explode(',', $request->delete) as $attendee_id) {
                $attendee = VendorRegistrationAttendee::find($attendee_id);
                $template = EmailTemplate::where('code', 'vendor-rep-delete')->first();
                $name = $attendee->name;
                $email =  $attendee->email;
                $subject = $template->subject;

                $body = $template->body;
                $body = str_replace('[COMPANY]', $vendorRegistrationSubmission->organization->name, $body);
                $body = str_replace('[CONFERENCE]', $vendorRegistrationSubmission->conference->name, $body);
                $body = str_replace('[SUBMITTED_BY_USER]', auth()->user()->name, $body);

                $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $vendorRegistrationSubmission);
                dispatch($job);
            }

            VendorRegistrationAttendee::whereIn('id', explode(',', $request->delete))->delete();
        }
        return redirect()->back()->with('success', 'Vendor Representatives Updated');

        // return redirect()->route('dashboard')->with('success', 'Vendor Representatives Updated');
    }

    public function liveFire(VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // $attendees = VendorRegistrationAttendee::where('vendor_registration_submission_id')->with('user:id')
        $bringings = ['Firearm', 'Less lethal launcher', 'Drone', 'Robotics', 'Vehicle demo', 'Optics', 'Suppressors', 'K9', 'Body armor, plate carriers, shields', 'Items to display on a table(s)'];
        $firearms = ['Pistol', 'Shotgun', 'Carbine / Rifle', 'Precision Rifle / Sniper Rifle'];
        $calibers = ['Any pistol caliber', 'Any shotgun caliber', 'Any .223/.556 caliber', 'Any 7.62 caliber', 'Any .300 caliber', '.50BMG'];

        return view('site.dashboard.vendor-registrations.live-fire', compact('vendorRegistrationSubmission', 'bringings', 'firearms', 'calibers'));
    }

    public function liveFirePost(Request $request, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd(implode(', ', $request->bringing));
        $submission = new LiveFireSubmission();
        $submission->vendor_registration_submission_id = $vendorRegistrationSubmission->id;
        $submission->user_id = auth()->user()->id;
        $submission->bringing = implode(', ', $request->bringing);
        if (in_array('Firearm', $request->bringing)) {
            $submission->firearm = implode(', ', $request->firearm);
            $submission->caliber = implode(', ', $request->caliber);
        }
        $submission->share = $request->share;
        if ($request->share == "Yes") {
            $submission->share_with = $request->share_with;
        }
        $submission->description = $request->description;
        $submission->save();

        return redirect()->route('dashboard.vendor-registrations.edit', $vendorRegistrationSubmission)->with('success', 'Live Fire Form Submitted');
    }

    public function barter(Request $request, VendorRegistrationSubmission $vendorRegistrationSubmission, Barter $barter)
    {
        $barter->comments = $request->comments;
        $barter->completed_user_id = auth()->user()->id;
        $barter->completed_at = now();
        $barter->update();

        $subject = "Barter form submitted by " . $vendorRegistrationSubmission->organization->name;
        $content = "<p>Barter form submitted by <strong>" . $vendorRegistrationSubmission->organization->name . "</strong>.</p>";
        $content = $content . "<p>" . $request->comments . "</p>";

        $user = User::where('email', 'patrick.fiorilli@otoa.org')->first();
        $email = $user->email;
        Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        $user = User::where('email', 'terry.graham@otoa.org')->first();
        $email = $user->email;
        Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        return redirect()->back()->with('success', 'Barter Form Submitted');
    }
}
