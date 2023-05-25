<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function primaryUsers()
    {
        return $this->hasMany(User::class)->orderBy('name');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function vendorRegistrationSubmissions()
    {
        return $this->hasMany(VendorRegistrationSubmission::class);
    }
    public function vendorPage()
    {
        return $this->hasOne(VendorPage::class);
    }
    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function notes()
    {
        return $this->hasMany(OrganizationNote::class);
    }

    public function trainingCourseHolds()
    {
        return $this->hasMany(TrainingCourseHold::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(AuthorizeSubscription::class);
    }

    public function activeSubscriptions()
    {

        $subscriptions = AuthorizeSubscription::where('organization_id', $this->id)
            ->where(function ($query) {
                $query->where('ends_at', null)->orWhere('ends_at', '>=', now());
            })
            ->get();
        return $subscriptions;
    }
}
