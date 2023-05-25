<?php

namespace App\Http\Controllers;

use App\Models\AuthorizeSubscription;
use App\Models\User;
use App\Models\Profile;
use App\Models\Conference;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\UserEmailFree;
use App\Models\TrainingCourse;
use App\Models\ConferenceAttendee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Models\TrainingCourseAttendee;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardOrganizationController extends Controller
{
    public function changeOrganization(Request $request)
    {
        session()->put('organization_id', $request->organization_id);
        return redirect()->back();
    }

    public function index()
    {
        // $organization = auth()->user()->organization;
        $organization = Organization::find(session()->get('organization_id'));

        $organization_users = User::where(function ($query) use ($organization) {
            $query->whereIn('id', $organization->primaryUsers->pluck('id'))
                ->orWhereIn('id', $organization->users->pluck('id'));
        })
            ->where('deleted_at', null)
            ->orderBy('name')
            ->get();

        $organization_calendar = TrainingCourseAttendee::whereIn('user_id', $organization_users->pluck('id'))
            ->whereHas('trainingCourse', function ($query) {
                $query->where('start_date', '>=', now());
            })
            ->get()
            ->sortBy('trainingCourse.start_date');


        $conferenceCalendar = ConferenceAttendee::whereIn('user_id', $organization_users->pluck('id'))
            ->with('conference', function ($query) {
                $query->where('end_date', '>=', now());
            })
            ->get()->groupBy('conference.name');

        $organizations = Organization::where('id', auth()->user()->organization->id)
            ->orWhereIn('id', auth()->user()->organizations->pluck('id'))
            ->get()
            ->pluck('name', 'id');

        return view('site.dashboard.organization.index', compact('organizations', 'conferenceCalendar', 'organization', 'organization_calendar', 'organization_users'));
    }
    public function users()
    {
        // $users = User::where('organization_id', auth()->user()->organization_id)
        //     ->orderBy('name')
        //     ->get();

        // session()->put('organization_id', auth()->user()->organization->id);
        // session()->put('organization_id', 736);

        $organization = Organization::find(session()->get('organization_id'));

        $users = User::whereIn('id', $organization->primaryUsers->pluck('id'))
            ->orWhereIn('id', $organization->users->pluck('id'))
            ->orderBy('name')
            ->get();

        return view('site.dashboard.organization.users', compact('users'));
    }
    public function user(User $user)
    {
        // TODO - make it so organization admin can only see their own users
        // if (!($user->organization_id == auth()->user()->organization_id || in_array(auth()->user()->organization_id, $user->organizations->pluck('id')->toArray()))) {
        //     abort(403, 'This users is not in your organization');
        // }

        // $trainingCourseAttendees = TrainingCourseAttendee::where('training_course_attendees.user_id', $user->id)->join('training_courses', 'training_course_attendees.training_course_id', '=', 'training_courses.id')
        //     ->orderBy('training_courses.start_date', 'DESC')
        //     ->get(['training_course_attendees.*']);

        $trainingCourseAttendees = TrainingCourseAttendee::where('user_id', $user->id)
            ->whereHas('trainingCourse')
            // ->whereHas('trainingCourse', function ($query) {
            //     $query->where('start_date', '>=', now());
            // })
            ->get()
            ->sortBy('trainingCourse.start_date');

        $admin_organization = Organization::find(session()->get('organization_id'));

        return view('site.dashboard.organization.user', compact('user', 'trainingCourseAttendees', 'admin_organization'));
    }





    public function userCreate()
    {
        if (request()->query('redirect') == 'training') {
            Session::flash('do-redirect', 'training');
        }
        if (request()->query('redirect') == 'conference') {
            Session::flash('do-redirect', 'conference');
        }
        $organization = Organization::find(session()->get('organization_id'));

        return view('site.dashboard.organization.user-create', compact('organization'));
    }

    public function userStore(Request $request)
    {
        $organization = Organization::find(session()->get('organization_id'));

        $email = trim($request->email);
        $user = User::where('email', $email)->withTrashed()->first();

        if ($user) {
            return redirect()->back()->with('found', $email);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::uuid());
        $user->organization_id = $organization->id;
        $user->save();

        $profile = new Profile();
        $profile->phone = $request->phone;
        $user->profile()->save($profile);

        $user->assignRole('Customer');


        $template = EmailTemplate::where('code', 'org-admin-user-added')->first();
        $email = $user->email;
        $subject = $template->subject;
        $content = $template->body;
        $content = str_replace('[ORGANIZATION]', $organization->name, $content);
        $content = str_replace('[ADMIN_NAME]', auth()->user()->name, $content);
        $content = str_replace('[ADMIN_EMAIL]', auth()->user()->email, $content);
        $content = str_replace('<a ', '<a style="color:#d49c6a;font-weight:700;text-decoration:none;" ', $content);

        Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
            $send->to($email)->subject($subject);
        });

        $check = UserEmailFree::where('email', $user->email)->where('used_at', null)->first();
        if ($check) {
            $user->createOrGetStripeCustomer();
            $user->newSubscription('default', config('site.stripe_standard_subscription'))
                ->withCoupon(config('site.stripe_discount'))
                ->add();
            $check->used_at = now();
            $check->update();
        }

        if (Session::get('do-redirect') == 'training') {
            $trainingCourse = TrainingCourse::find(Session::get('training'));
            return redirect()->route('trainingCourse.register', [$trainingCourse->training, $trainingCourse])->with('success', 'User added to your organization');
        }
        if (Session::get('do-redirect') == 'conference') {
            $conference = Conference::find(Session::get('conference'));
            return redirect()->route('conference.register', $conference)->with('success', 'User added to your organization');
        }

        return redirect()->route('dashboard.organization.users')->with('success', 'User added to your organization');
    }


    public function userEdit(User $user)
    {
        // TODO - make it so organization admin can only edit their own users

        return view('site.dashboard.organization.user-edit', compact('user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->profile->phone = $request->phone;
        $user->update();
        $user->profile->update();
        return redirect()->back()->with('success', 'User Updated');
    }

    public function userSubscribe(Request $request, User $user, AuthorizeSubscription $authorizeSubscription)
    {

        // $organization = Organization::find(session()->get('organization_id'));

        // $organization_subscription = AuthorizeSubscription::where('organization_id', $organization->id)->first();

        $subscription = new AuthorizeSubscription;
        $subscription->user_id = $user->id;
        $subscription->parent_id = $authorizeSubscription->id;
        $subscription->authorize_plan = $authorizeSubscription->authorize_plan;
        $subscription->save();
        return redirect()->back()->with('success', $user->name . ' added to ' . $authorizeSubscription->authorize_plan);
    }

    public function userCancel(Request $request, User $user)
    {
        $user->subscription()->delete();
        return redirect()->back()->with('success', 'User subscription canceled');
    }


    public function edit()
    {
        $organization = auth()->user()->organization;
        return view('site.dashboard.organization.edit', compact('organization'));
    }
    public function update(Request $request)
    {
        $organization = auth()->user()->organization;
        $organization->address = $request->address;
        $organization->city = $request->city;
        $organization->state = $request->state;
        $organization->zip = $request->zip;
        $organization->website = $request->website;
        $organization->description = $request->description;

        if ($request->image) {
            $fileName = $request->image->getClientOriginalName();
            $fileExt = $request->image->getClientOriginalExtension();
            $file_name = pathinfo($fileName, PATHINFO_FILENAME);
            $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;

            $resize = Image::make($request->image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream()->detach();
            Storage::disk('s3')->put('organizations/' . $newfileName, $resize);

            $organization->image = $newfileName;
        }

        $organization->update();

        return redirect()->route('dashboard')->with('success', 'Company Profile Updated');
    }
}
