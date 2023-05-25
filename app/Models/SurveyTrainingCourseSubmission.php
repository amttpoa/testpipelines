<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyTrainingCourseSubmission extends Model
{
    use HasFactory, SoftDeletes;

    public function lines()
    {
        return $this->hasMany(SurveyTrainingCourseLine::class);
    }

    public function trainingCourseAttendee()
    {
        return $this->belongsTo(TrainingCourseAttendee::class);
    }
    public function trainingCourse()
    {
        return $this->belongsTo(TrainingCourse::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
