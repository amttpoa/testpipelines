<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use App\Models\Course;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Profile;
// use PDF;
use App\Models\Conference;
use App\Models\UploadFile;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Models\UploadFolder;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\CourseAttendee;
use App\Models\TrainingCourse;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ConferenceAttendee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Models\TrainingCourseAttendee;
use App\Jobs\SendVendorDefaultEmailJob;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Storage;
use App\Models\SurveyTrainingCourseLine;
use App\Models\SurveyConferenceCourseLine;
use App\Models\VendorRegistrationAttendee;
use App\Models\VendorRegistrationSubmission;
use App\Models\SurveyTrainingCourseSubmission;
use App\Models\SurveyConferenceCourseSubmission;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $upcomingConferences = Conference::where('end_date', '>=', now())
            ->where('conference_visible', 1)
            ->orderBy('start_date')
            ->get();

        // $instructorConferences = Conference::where('end_date', '>=', now())
        //     ->whereHas('courses', function ($q) {
        //         $q->where('user_id', auth()->user()->id);
        //     })
        //     ->get();

        $instructorConferences = Conference::where('end_date', '>=', now())
            ->whereHas('courses', function ($query) {

                $query->where(function ($q) {
                    $q->where('user_id', auth()->user()->id)
                        ->orWhere(
                            function ($q2) {
                                $q2->whereIn('id', DB::table('course_user')->where('user_id', auth()->user()->id)->pluck('course_id'));
                            }
                        );
                });
            })
            ->orderBy('start_date', 'DESC')
            ->get()
            ->map(function ($conference) {
                $conference->courses->map(function ($course) use ($conference) {
                    $course->sub_instructor_count = $course->users()->where('user_id', auth()->user()->id)->count();
                    return $course;
                });
                $conference->sub_instructor_count = $conference->courses->sum('sub_instructor_count');
                return $conference;
            });


        $instructorCourses = Course::where('user_id', auth()->user()->id)
            ->orderBy('conference_id')
            ->orderBy('start_date')
            ->get()
            ->groupBy('conference.name');


        $instructorCoursesWarning = Course::where('user_id', auth()->user()->id)
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                return $query->where('description', null)->orWhere('requirements', null);
            })
            ->whereHas('conference', function ($q) {
                $q->where('conference_visible', 1);
            })
            ->orderBy('start_date')
            ->get();

        // dd($instructorCoursesWarning);

        // @if(auth()->user()->courses->where('end_date', '>=', now())->where(function ($query) {
        //     return $query->where('description', null)->orWhere('requirements', null);
        //     })->isNotEmpty())

        // $instructorTrainingCourses = TrainingCourse::where('user_id', auth()->user()->id)
        //     ->orWhereHas('users', function ($q) {
        //         $q->where('user_id', auth()->user()->id);
        //     })
        //     ->orderBy('training_id')
        //     ->orderBy('start_date')
        //     ->get();
        $instructorTrainingCourses = TrainingCourse::where(function ($q) {
            $q->where('user_id', auth()->user()->id)
                ->orWhereHas('users', function ($q) {
                    $q->where('user_id', auth()->user()->id);
                });
        })
            ->where('end_date', '>=', now())
            ->orderBy('training_id')
            ->orderBy('start_date')
            ->get();

        $trainingCourses = TrainingCourse::whereHas('attendees', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->get();



        $trainingCourseAttendees = TrainingCourseAttendee::where('training_course_attendees.user_id', auth()->user()->id)
            ->where('training_courses.end_date', '>', now())
            ->join('training_courses', 'training_course_attendees.training_course_id', '=', 'training_courses.id')
            ->orderBy('training_courses.start_date', 'ASC')
            ->get(['training_course_attendees.*']);

        $conferenceAttendees = ConferenceAttendee::where('user_id', auth()->user()->id)
            ->whereHas('conference', function ($q) {
                return $q->where('end_date', '>=', now());
            })
            ->get();


        $organization = auth()->user()->organization;

        $organization_users = null;
        if (auth()->user()->can('organization-admin')) {

            if (!session()->get('organization_id') && auth()->user()->organization) {
                session()->put('organization_id', auth()->user()->organization->id);
            }

            $organization = Organization::find(session()->get('organization_id'));
            $organization_users = User::where(function ($query) use ($organization) {
                $query->whereIn('id', $organization->primaryUsers->pluck('id'))
                    ->orWhereIn('id', $organization->users->pluck('id'));
            })
                ->where('deleted_at', null)
                ->orderBy('name')
                ->get();
        }


        return view('site.dashboard.dashboard', compact('organization', 'organization_users', 'upcomingConferences', 'instructorConferences', 'instructorCourses', 'instructorTrainingCourses', 'trainingCourses', 'instructorCoursesWarning', 'trainingCourseAttendees', 'conferenceAttendees'));
    }

    public function instructionalVideos()
    {
        return view('site.instructional-videos');
    }



    public function folders()
    {
        $folders = UploadFolder::where('restriction', null)
            ->when(auth()->user()->can('staff'), function ($query) {
                $query->orWhere('restriction', 'Staff Only');
            })
            ->when(auth()->user()->can('staff-instructor'), function ($query) {
                $query->orWhere('restriction', 'Staff Instructors Only');
            })
            ->when(auth()->user()->can('board-of-directors'), function ($query) {
                $query->orWhere('restriction', 'Board of Directors Only');
            })
            ->orderBy('order')
            ->get();
        return view('site.dashboard.files.folders', compact('folders'));
    }
    public function files(UploadFolder $uploadFolder)
    {
        return view('site.dashboard.files.files', compact('uploadFolder'));
    }
    public function fileUpload(Request $request, UploadFolder $uploadFolder)
    {
        $originalName = $request->file->getClientOriginalName();
        $fileName = "OTOA-" . time() . "-" . $originalName;

        Storage::disk('s3')->putFileAs('uploads/share', $request->file, $fileName);

        $upload = new UploadFile;
        $upload->user_id = auth()->user()->id;
        $upload->name = $request->name ? $request->name : $fileName;
        $upload->description = $request->description;
        $upload->upload_folder_id = $uploadFolder->id;
        $upload->file_name = $fileName;
        $upload->file_original = $originalName;
        $upload->file_ext = strtolower($request->file->extension());
        $upload->size = $request->file->getSize();
        $upload->save();

        return redirect()->back()->with('success', 'File Added');
    }
    public function fileEdit(UploadFolder $uploadFolder, UploadFile $uploadFile)
    {
        return view('site.dashboard.files.edit', compact('uploadFolder', 'uploadFile'));
    }
    public function fileUpdate(Request $request, UploadFolder $uploadFolder, UploadFile $uploadFile)
    {
        $uploadFile->name = $request->name;
        $uploadFile->description = $request->description;
        $uploadFile->save();

        return redirect()->route('dashboard.upload-files.index', $uploadFolder)->with('success', 'File Updated');
    }
    public function fileDestroy(UploadFile $uploadFile)
    {
        $uploadFile->delete();
        return redirect()->back()->with('success', 'File Deleted');
    }


    public function profile()
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();
        return view('site.dashboard.profile', compact('profile'));
    }

    public function profilePatch(Request $request)
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        $profile->phone = $request->phone;

        if (auth()->user()->can('general-staff')) {
            $profile->title = $request->title;
            $profile->birthday = $request->birthday;
            $profile->address = $request->address;
            $profile->city = $request->city;
            $profile->state = $request->state;
            $profile->zip = $request->zip;
            $profile->bio = $request->bio;
            $profile->shirt_size = $request->shirt_size;
            $profile->pants_waist = $request->pants_waist;
            $profile->pants_inseam = $request->pants_inseam;
            $profile->shoe_size = $request->shoe_size;
            $profile->emergency_name = $request->emergency_name;
            $profile->emergency_relationship = $request->emergency_relationship;
            $profile->emergency_phone = $request->emergency_phone;
        }

        $profile->update();

        $profile->user->name = $request->name;
        $profile->user->organization_id = $request->organization_id;
        $profile->user->update();


        if ($request->organization_ids) {
            $organization_ids = array_diff($request->organization_ids, [0]);
            $profile->user->organizations()->sync($organization_ids);
        }


        return redirect()->route('dashboard.profile')
            ->with('success', 'Your profile has been updated');
    }

    public function profileImage()
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();
        return view('site.dashboard.profile-image', compact('profile'));
    }
    public function profileImageUpload(Request $request)
    {

        // dd($request);
        $fileName = $request->image->getClientOriginalName();
        $fileExt = $request->image->getClientOriginalExtension();

        $file_name = pathinfo($fileName, PATHINFO_FILENAME);

        $newfileName = $file_name . "-" . now()->timestamp . "." . $fileExt;


        // Storage::disk('s3')->put('profiles/' . $newfileName, $request->image);

        Storage::disk('s3')->putFileAs('profiles/', $request->image, $newfileName);



        // $filePath = $request->image->move(public_path('storage/profile'), $newfileName, 'public');
        if (auth()->user()->hasRole('Admin') && isset($request->user_id)) {
            $profile = Profile::where('user_id', $request->user_id)->first();
        } else {
            $profile = Profile::where('user_id', auth()->user()->id)->first();
        }
        $profile->image = $newfileName;
        $profile->update();

        $newFile = Storage::disk('s3')->url('profiles/' . $newfileName);

        return response()->json(['newFile' => $newFile, 'fileName' => $fileName]);
    }

    public function changePassword()
    {
        return view('site.dashboard.change-password');
    }

    public function changePasswordPatch(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if (Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->update();

            return redirect()->route('dashboard')
                ->with('success', 'Your password has been updated');
        } else {
            return redirect()->back()
                ->with('success', 'Your password was not correct');
        }
    }





    public function staffDirectory()
    {
        return view('site.dashboard.staff.staff-directory');
    }
    public function staffDirectoryStaff(User $user)
    {
        return view('site.dashboard.staff.staff-user', compact('user'));
    }

    public function benefits()
    {
        $page = Page::find(17);
        return view('site.dashboard.membership-benefits', compact('page'));
    }



    public function createOrganization()
    {
        $organization = auth()->user()->organization;
        return view('site.organization-create', compact('organization'));
    }
    public function storeOrganization(Request $request)
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

        // return redirect()->intended(RouteServiceProvider::HOME);
        return redirect()->route('dashboard');
    }
}
