<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorRegistrationAttendee extends Model
{
    use HasFactory, SoftDeletes;

    public function vendorRegistrationSubmission()
    {
        return $this->belongsTo(VendorRegistrationSubmission::class);
    }

    public function conference()
    {
        return $this->hasOneThrough(
            Conference::class,
            VendorRegistrationSubmission::class
        );
    }
}
