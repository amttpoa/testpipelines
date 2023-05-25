<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venue extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function conferences()
    {
        return $this->hasMany(Course::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function trainingCourses()
    {
        return $this->hasMany(TrainingCourse::class);
    }

    public function hotels()
    {
        return $this->belongsToMany(Hotel::class)->orderBy('name');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
