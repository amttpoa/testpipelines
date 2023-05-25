<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Radio;
use App\Models\Conference;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Jobs\EmailVendorAdJob;
use App\Jobs\EmailVendorRepJob;
use App\Models\LiveFireSubmission;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Jobs\SendVendorBillingEmailJob;
use App\Jobs\SendVendorDefaultEmailJob;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendVendorLivefireEmailJob;
use App\Models\VendorRegistrationAttendee;
use App\Models\VendorRegistrationSubmission;

class SiteFormController extends Controller
{
    public function exhibitionRegistration(Conference $conference)
    {
        if (auth()->user()) {
            if (!auth()->user()->organization->address) {
                return redirect()->route('organization.create', ['company' => 'incomplete']);
            }
        }

        $radios = Radio::orderBy('order')->get()->groupBy('field');
        $terms = Page::where('name', 'Terms and Conditions')->first();
        $sponsorships = Page::where('name', 'Conference Sponsorships')->first();
        return view('site.conferences.vendor-registration', compact('conference', 'radios', 'terms', 'sponsorships'));
    }
    public function exhibitionRegistrationPost(Conference $conference, Request $request)
    {
        // dd($request->lunch);
        $this->validate($request, [
            'sponsorship' => 'required',
            'live_fire' => 'required',
        ]);

        $submission = new VendorRegistrationSubmission();
        $submission->company_name = $request->company_name;
        $submission->company_website = $request->company_website;

        $submission->sponsorship = $request->sponsorship;

        $submission->advertising_name = $request->advertising_name;
        $submission->advertising_email = $request->advertising_email;
        $submission->advertising_phone = $request->advertising_phone;

        $submission->live_fire = $request->live_fire;
        $submission->live_fire_name = $request->live_fire_name;
        $submission->live_fire_email = $request->live_fire_email;
        $submission->live_fire_phone = $request->live_fire_phone;

        $submission->primary_name = $request->primary_name;
        $submission->primary_email = $request->primary_email;
        $submission->primary_phone = $request->primary_phone;

        $submission->lunch = $request->lunch;
        $submission->power = $request->power;
        $submission->tv = $request->tv;
        $submission->internet = $request->internet;
        $submission->tables = $request->tables;

        $submission->billing_name = $request->billing_name;
        $submission->billing_email = $request->billing_email;
        $submission->billing_phone = $request->billing_phone;

        $submission->comments = $request->comments;

        $submission->sponsorship_price = $request->sponsorship_price;
        $submission->live_fire_price = $request->live_fire_price;
        $submission->lunch_price = $request->lunch_price;
        $submission->power_price = $request->power_price;
        $submission->tv_price = $request->tv_price;
        $submission->internet_price = $request->internet_price;
        $submission->tables_price = $request->tables_price;
        $submission->total = $request->total;

        $submission->payment_agreement = 1;
        $submission->terms_agreement = 1;

        $submission->conference_id = $conference->id;
        $submission->user_id = auth()->user()->id;
        $submission->organization_id = auth()->user()->organization->id;

        $submission->website_description = $request->website_description;

        if (request('image')) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $resize = Image::make($request->file('image'))->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream()->detach();
            Storage::disk('s3')->put('vendor-logos/' . $newfileName, $resize);

            $submission->image = $newfileName;
        }

        $tables_qty = 1;
        $ad_email = '';
        if ($request->sponsorship == 'Hospitality Night Sponsor') {
            $tables_qty = 2;
            $ad_email = "<p style='text-align:center;'><img src='" . config('app.url') . "/img/brochure-quarter-page.png' style='width:200px;' /></p>";
        }
        if ($request->sponsorship == 'Silver Sponsor') {
            $tables_qty = 2;
            $ad_email = "<p style='text-align:center;'><img src='" . config('app.url') . "/img/brochure-half-page.png' style='width:200px;' /></p>";
        }
        if ($request->sponsorship == 'Gold Sponsor') {
            $tables_qty = 3;
            $ad_email = "<p style='text-align:center;'><img src='" . config('app.url') . "/img/brochure-full-page.png' style='width:200px;' /></p>";
        }
        if ($request->sponsorship == 'Platinum Sponsor') {
            $tables_qty = 4;
            $ad_email = "<p style='text-align:center;'><img src='" . config('app.url') . "/img/brochure-full-page.png' style='width:200px;' /></p>";
        }
        if ($request->sponsorship == 'Corporate Sponsor' or $request->sponsorship == 'Premier Corporate Sponsor') {
            $tables_qty = 4;
            $ad_email = "<p style='text-align:center;'><img src='" . config('app.url') . "/img/brochure-two-page.png' style='width:100%;' /></p>";
        }
        if ($request->tables == '1 extra table') {
            $tables_qty = $tables_qty + 1;
        }
        if ($request->tables == '2 extra tables') {
            $tables_qty = $tables_qty + 2;
        }
        $submission->tables_qty = $tables_qty;
        // $submission->tables_qty = $request->tables_price / 60;        
        $submission->lunch_qty = $request->lunch + (count($request->attendee_name) >= 2 ? 2 : 1);

        $submission->uuid = Str::uuid();

        $submission->save();

        if ($request->attendee_name) {
            foreach ($request->attendee_name as $key => $attendee_name) {

                $attendee = new VendorRegistrationAttendee();
                $attendee->name = $request->attendee_name[$key];
                $attendee->email = $request->attendee_email[$key];
                $attendee->phone = $request->attendee_phone[$key];
                $submission->attendees()->save($attendee);

                $template = EmailTemplate::where('code', 'vendor-reps')->first();
                $name = $attendee->name;
                $email = $attendee->email;
                $subject = $template->subject;

                $body = $template->body;
                $body = str_replace('[COMPANY]', $submission->organization->name, $body);
                $body = str_replace('[CONFERENCE]', $submission->conference->name, $body);
                $body = str_replace('[SUBMITTED_BY_USER]', $submission->user->name, $body);
                $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

                $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $submission);
                dispatch($job);
            }
        }

        if ($request->advertising_email) {
            $template = EmailTemplate::where('code', 'vendor-ad')->first();
            $name = $request->advertising_name;
            $email = $request->advertising_email;
            $subject = $template->subject;

            $radio = Radio::where('field', 'sponsorship')->where('value', $submission->sponsorship)->first();
            $sponsorship = "Your <strong>" . $submission->sponsorship . "ship</strong> level provides <strong>" . $radio->benefit . "</strong>.";

            $body = $template->body;
            $body = str_replace('[COMPANY]', $submission->user->organization->name, $body);
            $body = str_replace('[CONFERENCE]', $submission->conference->name, $body);
            $body = str_replace('[SUBMITTED_BY_USER]', $submission->user->name, $body);
            $body = str_replace('[SPONSORSHIP]', $sponsorship, $body);
            $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

            $body = $body . $ad_email;

            $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $submission);
            dispatch($job);
        }

        if ($request->live_fire_email) {
            $template = EmailTemplate::where('code', 'vendor-livefire')->first();
            $name = $request->live_fire_name;
            $email = $request->live_fire_email;
            $subject = $template->subject;

            $link = "<a href='" . route('liveFireForm', $submission) . "'>";

            $body = $template->body;
            $body = str_replace('[COMPANY]', $submission->user->organization->name, $body);
            $body = str_replace('[CONFERENCE]', $submission->conference->name, $body);
            $body = str_replace('[SUBMITTED_BY_USER]', $submission->user->name, $body);
            $body = str_replace('[LIVEFIRE_LINK]', $link, $body);
            $body = str_replace('[/LIVEFIRE_LINK]', '</a>', $body);
            $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

            $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $submission);
            dispatch($job);
        }

        if ($request->billing_email) {
            $template = EmailTemplate::where('code', 'vendor-billing')->first();
            $name = $request->billing_name;
            $email = $request->billing_email;
            $subject = $template->subject;

            $body = $template->body;
            $body = str_replace('[COMPANY]', $submission->user->organization->name, $body);
            $body = str_replace('[CONFERENCE]', $submission->conference->name, $body);
            $body = str_replace('[SUBMITTED_BY_USER]', $submission->user->name, $body);
            $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

            $job = new SendVendorDefaultEmailJob($name, $email, $subject, $body, $submission);
            dispatch($job);
        }

        $user = auth()->user();

        $template = EmailTemplate::where('code', 'vendor-user')->first();
        $name = $user->name;
        $email = $user->email;
        $subject = $template->subject;
        $message = "";

        $body = $template->body;
        $body = str_replace('[COMPANY]', $submission->user->organization->name, $body);
        $body = str_replace('[CONFERENCE]', $submission->conference->name, $body);
        $body = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $body);

        // $job = new EmailVendorRepJob($name, $email, $subject, $message, $submission);
        // dispatch($job);

        Mail::send('emails.vendor-registration-submission', compact('submission', 'user', 'body'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });



        return redirect()->route('exhibitionRegistration', ['conference' => $conference, 'registration' => 'complete']);
    }



    public function liveFire(VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd($vendorRegistrationSubmission);
        // $attendees = VendorRegistrationAttendee::where('vendor_registration_submission_id')->with('user:id')
        $bringings = ['Firearm', 'Less lethal launcher', 'Drone', 'Robotics', 'Vehicle demo', 'Optics', 'Suppressors', 'K9', 'Body armor, plate carriers, shields', 'Items to display on a table(s)'];
        $firearms = ['Pistol', 'Shotgun', 'Carbine / Rifle', 'Precision Rifle / Sniper Rifle'];
        $calibers = ['Any pistol caliber', 'Any shotgun caliber', 'Any .223/.556 caliber', 'Any 7.62 caliber', 'Any .300 caliber', '.50BMG'];
        $conference = $vendorRegistrationSubmission->conference;

        return view('site.conferences.live-fire-form', compact('conference', 'vendorRegistrationSubmission', 'bringings', 'firearms', 'calibers'));
    }

    public function liveFirePost(Request $request, VendorRegistrationSubmission $vendorRegistrationSubmission)
    {
        // dd(implode(', ', $request->bringing));
        // $submission = LiveFireSubmission::where()
        if ($vendorRegistrationSubmission->liveFireSubmission) {
            $submission = $vendorRegistrationSubmission->liveFireSubmission;
        } else {
            $submission = new LiveFireSubmission();
        }

        $submission->vendor_registration_submission_id = $vendorRegistrationSubmission->id;
        if (auth()->user()) {
            $submission->user_id = auth()->user()->id;
        }
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

        if ($vendorRegistrationSubmission->liveFireSubmission) {
            $submission->update();
        } else {
            $submission->save();
        }

        return redirect()->route('liveFireForm', ['vendorRegistrationSubmission' => $vendorRegistrationSubmission, 'form' => 'complete']);
    }
}
