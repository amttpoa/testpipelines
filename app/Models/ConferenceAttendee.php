<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConferenceAttendee extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['checked_in_at'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->registered_by_user_id = auth()->user()->id;

            $attendeeArray = explode(' ', $model->user->name);
            $card_first_name = $attendeeArray[0];
            array_shift($attendeeArray);
            $card_last_name = implode(' ', $attendeeArray);
            $model->card_first_name = $card_first_name;
            $model->card_last_name = $card_last_name;
            $model->card_type = 'Attendee';
            if ($model->user->can('conference-instructor')) {
                $model->card_type = 'Instructor';
            }
            if ($model->user->can('staff')) {
                $model->card_type = 'Staff';
            }

            $model->uuid = Str::uuid();
        });

        // static::created(function ($conferenceAttendee) {
        //     $name = $conferenceAttendee->user->name;

        //     $email = $conferenceAttendee->user->email;
        //     $subject = "You have been registered for the " . $conferenceAttendee->conference->name;
        //     $email_body = "";

        //     Mail::send('emails.conference-registered', compact('conferenceAttendee'), function ($send) use ($email, $subject) {
        //         $send->to($email)->subject($subject);
        //     });
        // });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function courseAttendees()
    {
        return $this->hasMany(CourseAttendee::class);
    }
    public function registeredByUser()
    {
        return $this->belongsTo(User::class, 'registered_by_user_id', 'id');
    }
    public function checkedInByUser()
    {
        return $this->belongsTo(User::class);
    }
}
