<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barter extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['completed_at'];

    public function vendorRegistrationSubmission()
    {
        return $this->belongsTo(VendorRegistrationSubmission::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'completed_user_id', 'id');
    }
}
