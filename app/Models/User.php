<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'created_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function subscribed()
    {
        // $authorizeSubscription = AuthorizeSubscription::where('user_id')

        // $this->subscription->where('trail_end_at', null);

        // $subs = $this->subscriptions->where('ends_at', null)->orWhere('ends_at', '>=', now());
        // ->where(function ($query) {
        //     $query->where('ends_at', null);
        // })
        // ->where(function ($query) {
        //     $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
        // });
        // dd($subs)
        // ->isNotEmpty();

        // return $this->subscriptions
        //     ->where(function ($query) {
        //         $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
        //     })
        //     ->isNotEmpty();
        // return $subs->isNotEmpty();

        // $subscriptions = AuthorizeSubscription::where('user_id', $this->id)
        //     ->where(function ($query) {
        //         $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
        //     })
        //     ->get();
        // return $subscriptions->isNotEmpty();
        return $this->subscription() ? true : false;
    }
    public function subscription()
    {
        // return $this->subscriptions->where('ends_at', null)->isNotEmpty() ? $this->subscriptions->where('ends_at', null)->first() : false;
        // return $this->subscriptions
        //     ->where(function ($query) {
        //         $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
        //     })->first();
        // return false;
        $subscription = AuthorizeSubscription::where('user_id', $this->id)
            ->where(function ($query) {
                $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
            })
            ->first();
        return $subscription;
    }
    // public function subscribed()
    // {
    //     // $authorizeSubscription = AuthorizeSubscription::where('user_id')

    //     // $this->subscription->where('trail_end_at', null);
    //     $sub = $this->subscriptions
    //         ->where('ends_at', null)
    //         ->orWhere('ends_at', '>=', now())
    //         ->first();
    //     return $sub->isNotEmpty();

    //     return $this->subscriptions->where('ends_at', null)->isNotEmpty();
    // }
    // public function subscription()
    // {
    //     $sub = $this->subscriptions
    //         ->where('ends_at', null)
    //         ->orWhere('ends_at', '>=', now())
    //         ->first();
    //     return $sub;

    //     // return false;
    // }


    public function subscriptions()
    {
        return $this->hasMany(AuthorizeSubscription::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }

    public function allOrganizations()
    {
        return Organization::where('id', $this->organization->id)
            ->orWhereIn('id', $this->organizations->pluck('id'))
            ->get();
    }

    public function courses()
    {
        return $this->hasMany(Course::class)->orderBy('start_date', 'DESC');
    }
    public function subCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function trainingCourseAttendees()
    {
        return $this->hasMany(TrainingCourseAttendee::class);
    }
    public function registeredTrainingCourseAttendees()
    {
        return $this->hasMany(TrainingCourseAttendee::class, 'registered_by_user_id', 'id');
    }

    public function registeredConferenceAttendees()
    {
        return $this->hasMany(ConferenceAttendee::class, 'registered_by_user_id', 'id');
    }

    public function checkedInConferenceAttendees()
    {
        return $this->hasMany(ConferenceAttendee::class, 'checked_in_by_user_id', 'id');
    }

    public function trainingCourses()
    {
        return $this->hasMany(TrainingCourse::class)->orderBy('start_date', 'DESC');
    }
    public function subTrainingCourses()
    {
        return $this->belongsToMany(TrainingCourse::class);
    }

    public function trainingWaitlists()
    {
        return $this->hasMany(TrainingWaitlist::class);
    }


    public function conferenceAttendees()
    {
        return $this->hasMany(ConferenceAttendee::class);
    }
    public function courseAttendees()
    {
        return $this->hasMany(CourseAttendee::class);
    }

    public function vendorRegistrationSubmissions()
    {
        return $this->hasMany(VendorRegistrationSubmission::class);
    }

    public function conferenceCourseSurveys()
    {
        return $this->hasMany(SurveyConferenceCourseSubmission::class);
    }

    public function trainingCourseSurveys()
    {
        return $this->hasMany(SurveyTrainingCourseSubmission::class);
    }

    // public function conferences()
    // {
    //     return $this->hasOneThrough(
    //         Course::class,
    //         Conference::class
    //     );

    //     // return $this->hasOneThrough(
    //     //     Owner::class,
    //     //     Car::class,
    //     //     'mechanic_id', // Foreign key on the cars table...
    //     //     'car_id', // Foreign key on the owners table...
    //     //     'id', // Local key on the mechanics table...
    //     //     'id' // Local key on the cars table...
    //     // );
    // }

    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
    public function conferenceHotelRequests()
    {
        return $this->hasMany(ConferenceHotelRequest::class);
    }

    public function userNotes()
    {
        return $this->hasMany(UserNote::class, 'id', 'note_user_id');
    }


    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function trainingCourseHolds()
    {
        return $this->hasMany(TrainingCourseHold::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function venues()
    {
        return $this->hasMany(Venue::class);
    }


    public function events()
    {
        return $this->hasMany(Event::class);
    }
    public function eventAttendees()
    {
        return $this->hasMany(EventAttendee::class);
    }

    public function subscribes()
    {
        return $this->hasMany(Subscribe::class);
    }

    public function conferenceCoursesTeaching(Conference $conference)
    {
        return Course::where('conference_id', $conference->id)
            ->where('user_id', $this->id)
            ->orWhereIn('id', DB::table('course_user')->where('user_id', $this->id)->pluck('course_id')->toArray())
            ->orderBy('start_date', 'ASC')
            ->get();
    }

    public function scopeCoursesTeaching()
    {
        return Course::where('user_id', $this->id)
            ->orWhereIn('id', DB::table('course_user')->where('user_id', $this->id)->pluck('course_id')->toArray())
            ->orderBy('start_date', 'DESC')
            ->get();
    }
    public function scopeTrainingCoursesTeaching()
    {
        return TrainingCourse::where('user_id', $this->id)
            ->orWhereIn('id', DB::table('training_course_user')->where('user_id', $this->id)->pluck('training_course_id')->toArray())
            ->orderBy('start_date', 'DESC')
            ->get();
    }


    public function scopeTeachingCoursesFor($query, Conference $conference)
    {
        $query->whereHas('courses', function ($query) use ($conference) {
            $query->where('conference_id', $conference->id);
        })
            ->orWhereHas('subCourses', function ($query) use ($conference) {
                $query->where('conference_id', $conference->id);
            });
    }

    // public function scopeViewFiles($query)
    // {

    //     $query->permission('file-sharing');

    //     // $query->when(!auth()->user()->can('contract-admin'), function ($query) {
    //     //     $query->where('user_id', auth()->user()->id);
    //     // })

    //     // $query->whereHas('courses', function ($query) use ($conference) {
    //     //     $query->where('conference_id', $conference->id);
    //     // })
    //     //     ->orWhereHas('subCourses', function ($query) use ($conference) {
    //     //         $query->where('conference_id', $conference->id);
    //     //     });
    // }

}
