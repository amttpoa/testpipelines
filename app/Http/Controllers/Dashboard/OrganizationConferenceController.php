<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Conference;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\ConferenceAttendee;
use App\Http\Controllers\Controller;

class OrganizationConferenceController extends Controller
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

        $organization_calendar = ConferenceAttendee::whereIn('user_id', $organization_users->pluck('id'))
            ->get()->groupBy('conference.name');
        // ->sortByDesc('trainingCourse.start_date');
        // dd($organization_calendar);
        return view('site.dashboard.organization.conferences.index', compact('organization', 'organization_calendar'));
    }

    public function show(Conference $conference)
    {
        $organization = Organization::find(session()->get('organization_id'));

        $organization_users = User::where(function ($query) use ($organization) {
            $query->whereIn('id', $organization->primaryUsers->pluck('id'))
                ->orWhereIn('id', $organization->users->pluck('id'));
        })
            ->where('deleted_at', null)
            ->orderBy('name')
            ->get();

        $conference_attendees = ConferenceAttendee::whereIn('user_id', $organization_users->pluck('id'))
            ->get();
        // ->sortByDesc('trainingCourse.start_date');
        // dd($organization_calendar);

        return view('site.dashboard.organization.conferences.show', compact('organization', 'conference', 'conference_attendees'));
    }

    public function attendee(Conference $conference, ConferenceAttendee $conferenceAttendee)
    {
        $organization = Organization::find(session()->get('organization_id'));

        $organization_users = User::where(function ($query) use ($organization) {
            $query->whereIn('id', $organization->primaryUsers->pluck('id'))
                ->orWhereIn('id', $organization->users->pluck('id'));
        })
            ->where('deleted_at', null)
            ->orderBy('name')
            ->get();

        $conference_attendees = ConferenceAttendee::whereIn('user_id', $organization_users->pluck('id'))
            ->get();
        // ->sortByDesc('trainingCourse.start_date');
        // dd($organization_calendar);

        return view('site.dashboard.organization.conferences.attendee', compact('conferenceAttendee', 'organization', 'conference', 'conference_attendees'));
    }
}
