<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\TrainingCourse;
use App\Http\Controllers\Controller;
use App\Models\TrainingCourseAttendee;

class OrganizationTrainingController extends Controller
{
    public function index()
    {
        $organization = Organization::find(session()->get('organization_id'));

        $organization_users = User::where(function ($query) use ($organization) {
            $query->whereIn('id', $organization->primaryUsers->pluck('id'))
                ->orWhereIn('id', $organization->users->pluck('id'));
        })
            ->where('deleted_at', null)
            ->orderBy('name')
            ->get();

        $organization_calendar = TrainingCourseAttendee::whereIn('user_id', $organization_users->pluck('id'))
            // ->whereHas('trainingCourse', function ($query) {
            //     $query->where('start_date', '>=', now());
            // })
            ->whereHas('trainingCourse')
            ->get()
            ->sortByDesc('trainingCourse.start_date');

        return view('site.dashboard.organization.trainings.index', compact('organization', 'organization_calendar'));
    }


    public function show(TrainingCourse $trainingCourse)
    {
        return view('site.dashboard.organization.trainings.show', compact('trainingCourse'));
    }

    public function attendee(TrainingCourse $trainingCourse, TrainingCourseAttendee $trainingCourseAttendee)
    {
        return view('site.dashboard.organization.trainings.attendee', compact('trainingCourse', 'trainingCourseAttendee'));
    }
}
