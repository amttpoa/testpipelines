<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingCourseAttendee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->registered_by_user_id = auth()->user()->id;
        });

        static::created(function ($trainingCourseAteendee) {
            $name = $trainingCourseAteendee->user->name;

            $email = $trainingCourseAteendee->user->email;
            $subject = "You have been registered for " . $trainingCourseAteendee->trainingCourse->training->name;
            $email_body = "";

            Mail::send('emails.training-course-attendee-registered', compact('trainingCourseAteendee', 'name', 'email_body'), function ($send) use ($email, $subject) {
                $send->to($email)->subject($subject);
            });
        });
    }

    public function trainingCourse()
    {
        return $this->belongsTo(TrainingCourse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registeredByUser()
    {
        return $this->belongsTo(User::class);
    }

    public function surveyTrainingCourseSubmission()
    {
        return $this->hasOne(SurveyTrainingCourseSubmission::class);
    }
}
