<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Radio;
use App\Models\Staff;
use App\Models\Venue;
use App\Models\Course;
use App\Models\Vendor;
use App\Models\Partner;
use App\Models\Training;
use App\Models\Conference;
use App\Models\VendorPage;
use App\Models\FaqCategory;
use App\Models\Organization;
use App\Models\StaffSection;
use Illuminate\Http\Request;
use App\Jobs\SendOneEmailJob;
use App\Models\CourseAttendee;
use App\Models\TrainingCourse;
use App\Jobs\EmailVendorRepJob;
use App\Models\ConferenceAttendee;
use App\Models\CourseTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Models\TrainingCourseAttendee;
use Illuminate\Support\Facades\Storage;
use App\Models\VendorRegistrationAttendee;
use App\Models\VendorRegistrationSubmission;

class SiteController extends Controller
{

    public function home()
    {
        $conference = Conference::find(1);
        return view('home', compact('conference'));
    }

    public function page(Page $page)
    {
        return view('site.page', compact('page'));
    }

    public function w9()
    {
        return view('site.w-9');
    }
    public function mediaKit()
    {
        return view('site.media-kit');
    }
    public function faqs()
    {
        $categories = FaqCategory::orderBy('order')->get();
        return view('site.faqs', compact('categories'));
    }
    public function adSpecs()
    {
        return view('site.ad-specs');
    }
    public function conferenceHotels()
    {
        $ids = DB::table('hotel_venue')->where('venue_id', 1)->pluck('hotel_id');
        $hotels = Hotel::whereIn('id', $ids)->get();
        return view('site.conference-hotels', compact('hotels'));
    }
    public function conferenceAgendaAttendee()
    {
        $page = Page::find(12);
        return view('site.conferences.conference-agenda-attendee', compact('page'));
    }
    public function mondaySpeakers()
    {
        $page = Page::find(13);
        return view('site.conferences.monday-speakers', compact('page'));
    }


    public function host()
    {
        return view('site.host');
    }

    public function staff()
    {
        $sections = StaffSection::orderBy('order')->get();
        return view('site.staff', compact('sections'));
    }
    public function staffProfile(User $user)
    {
        if (!$user->can('show-profile-on-site')) {
            abort(404);
        }
        $courses = Course::where('start_date', '>=', now())
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('users', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->orderBy('start_date')
            ->get();

        $coursesGrouped = Course::where('user_id', $user->id)
            ->orWhereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderBy('start_date')
            ->get()
            ->groupBy(function ($conference) {
                return $conference->conference->name;
            });

        $trainingCourses = TrainingCourse::where('start_date', '>=', now())
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('users', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })

            ->orderBy('start_date')
            ->get();

        $trainingCoursesGrouped = TrainingCourse::where('user_id', $user->id)
            ->orWhereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderBy('start_date')
            ->get()
            ->groupBy(function ($training) {
                return $training->training->name;
            });

        return view('site.staffProfile', compact('user', 'courses', 'trainingCourses', 'trainingCoursesGrouped', 'coursesGrouped'));
    }


    public function venues()
    {
        $venues = Venue::orderBy('name')->get();
        return view('site.venues', compact('venues'));
    }
    public function venue(Venue $venue)
    {
        $courses = Course::where('venue_id', $venue->id)
            ->get()
            ->groupBy(function ($conference) {
                return $conference->conference->name;
            });

        $trainingCourses = TrainingCourse::where('venue_id', $venue->id)
            ->where('end_date', '>=', now())
            ->get();

        return view('site.venue', compact('venue', 'courses', 'trainingCourses'));
    }

    public function vendors()
    {
        $vendors = Vendor::orderBy('name')->get();
        $organizations = Organization::has('vendorPage')->orderBy('name')->get();
        return view('site.vendors', compact('vendors', 'organizations'));
    }
    public function vendor(VendorPage $vendorPage)
    {
        $organization = $vendorPage->organization;
        return view('site.vendor', compact('organization'));
    }


    public function partners()
    {
        $organizations = Organization::has('partner')->orderBy('name')->get();
        return view('site.partners', compact('organizations'));
    }
    public function partner(Partner $partner)
    {
        $organization = $partner->organization;
        return view('site.partner', compact('organization'));
    }


    public function hotels()
    {
        $hotels = Hotel::orderBy('name')->get();
        return view('site.hotels', compact('hotels'));
    }
    public function hotel(Hotel $hotel)
    {
        return view('site.hotel', compact('hotel'));
    }
}
