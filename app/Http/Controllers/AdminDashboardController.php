<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use App\Models\TrainingCourseAttendee;
use App\Models\VendorRegistrationSubmission;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $profiles = Profile::birthDayBetween(Carbon::now(), Carbon::now()->addWeek(4))->get();

        $birthdayUsers = User::permission('general-staff')
            ->whereHas('profile', function ($query) {
                $query->birthDayBetween(Carbon::now(), Carbon::now()->addWeek(4));
            })
            ->get()
            ->map(function ($user) {
                $user->sorter = $user->profile->birthday->format('m-d');
                return $user;
            })
            ->sortBy('sorter');

        // dd($birthdayUsers);

        $recentTrainingRegistrations = TrainingCourseAttendee::orderBy('created_at', 'DESC')->get()->take(10);
        $trainingCourses = TrainingCourse::where('end_date', '>=', now())->orderBy('start_date')->get()->take(4);
        $submissions = VendorRegistrationSubmission::orderBy('id', 'DESC')->get()->take(10);
        $organizations = Organization::orderBy('updated_at', 'DESC')->get()->take(10);
        $users = User::where('organization_id', null)->orWhere('organization_id', 0)->orderBy('created_at', 'DESC')->get();
        $allOrganizations = Organization::all();

        return view('dashboard-admin', compact('recentTrainingRegistrations', 'trainingCourses', 'submissions', 'organizations', 'users', 'allOrganizations', 'profiles', 'birthdayUsers'));
    }
}
