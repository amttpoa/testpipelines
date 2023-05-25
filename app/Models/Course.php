<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['start_date', 'end_date'];

    protected $guarded = [];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function instructor()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed();
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

    public function courseAttendees()
    {
        return $this->hasMany(CourseAttendee::class);
    }

    public function surveys()
    {
        return $this->hasMany(SurveyConferenceCourseSubmission::class);
    }

    public function parent()
    {
        return $this->hasOne(Course::class, 'id', 'link_id');
    }
    public function children()
    {
        return $this->hasMany(Course::class, 'link_id', 'id');
    }


    public function courseTags()
    {
        return $this->belongsToMany(CourseTag::class);
    }
}
