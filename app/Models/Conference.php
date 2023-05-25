<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Conference extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['start_date', 'end_date', 'registration_start_date', 'registration_end_date', 'vendor_start_date', 'vendor_end_date'];

    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class)->orderBy('start_date');
    }

    public function Xinstructors()
    {
        return $this->hasManyThrough(Course::class, User::class, 'id', 'user_id');
    }


    public function instructors()
    {


        return User::whereHas('courses', function ($query) {
            $query->where('conference_id', $this->id);
        })
            ->orWhereHas('subCourses', function ($query) {
                $query->where('conference_id', $this->id);
            })
            ->orderBy('name')
            ->get();
    }


    public function vendors()
    {
        return $this->hasMany(VendorRegistrationSubmission::class);
    }
    public function conferenceAttendees()
    {
        return $this->hasMany(ConferenceAttendee::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function freeCourse()
    {
        return $this->hasOne(Course::class, 'id', 'free_course_id');
    }



    public function venues(): HasManyThrough
    {
        return $this->hasManyThrough(Venue::class, Course::class, 'conference_id', 'id', 'id', 'venue_id')->distinct()->orderBy('name');
    }

    public function venueMedics(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, ConferenceVenueMedic::class, 'conference_id', 'id', 'id', 'user_id')->distinct()->orderBy('name');
    }

    public function conferenceHotelRequests()
    {
        return $this->hasMany(ConferenceHotelRequest::class);
    }

    public function reimbursements()
    {
        return $this->hasMany(Reimbursement::class);
    }
}
