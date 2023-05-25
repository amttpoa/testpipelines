<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseAttendee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected static function boot()
    {
        parent::boot();
        static::created(function ($courseAttendee) {
            $course = $courseAttendee->course;
            $course->filled = $course->courseAttendees->count();
            $course->available = $course->capacity - $course->filled;
            $course->update();
        });
        static::deleted(function ($courseAttendee) {
            $course = $courseAttendee->course;
            $course->filled = $course->courseAttendees->count();
            $course->available = $course->capacity - $course->filled;
            $course->update();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conferenceAttendee()
    {
        return $this->belongsTo(ConferenceAttendee::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function surveyConferenceCourseSubmission()
    {
        return $this->hasOne(SurveyConferenceCourseSubmission::class);
    }
}
