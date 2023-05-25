<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingCourse extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['start_date', 'end_date'];


    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }


    public function attendees()
    {
        return $this->hasMany(TrainingCourseAttendee::class);
    }

    public function trainingWaitlists()
    {
        return $this->hasMany(TrainingWaitlist::class);
    }
    public function trainingCourseHolds()
    {
        return $this->hasMany(TrainingCourseHold::class);
    }
}
