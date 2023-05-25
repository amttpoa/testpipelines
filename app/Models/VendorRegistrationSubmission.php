<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorRegistrationSubmission extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($vendorRegistrationSubmission) {

            $user = User::where('email', 'terry.graham@otoa.org')->first();
            // $user = User::where('email', 'keethm@gmail.com')->first();
            $email = $user->email;
            $subject = "New vendor registration - " . $vendorRegistrationSubmission->organization->name;
            $content = $vendorRegistrationSubmission->organization->name . " registered as a vendor";

            Mail::send('emails.plain', compact('user', 'content'), function ($send) use ($email, $subject) {
                $send->to($email)->subject($subject);
            });
        });
    }

    public function attendees()
    {
        return $this->hasMany(VendorRegistrationAttendee::class);
    }

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function notes()
    {
        return $this->hasMany(VendorRegistrationNote::class);
    }
    public function liveFireSubmission()
    {
        return $this->hasOne(LiveFireSubmission::class);
    }
    public function barter()
    {
        return $this->hasOne(Barter::class);
    }
}
