<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
    public function eventAttendees()
    {
        return $this->hasMany(EventAttendee::class);
    }
}
