<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    public function activeCourses()
    {
        return $this->hasMany(TrainingCourse::class)->where('active', 1)->orderBy('start_date', 'DESC');
    }
    public function courses()
    {
        return $this->hasMany(TrainingCourse::class)->orderBy('start_date');
    }
    public function upcomingCourses()
    {
        return $this->hasMany(TrainingCourse::class)
            ->where('visible', 1)
            ->where('end_date', '>=', now())
            ->orderBy('start_date');
    }
}
