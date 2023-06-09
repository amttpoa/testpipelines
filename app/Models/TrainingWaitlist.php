<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingWaitlist extends Model
{
    use HasFactory, SoftDeletes;

    public function trainingCourse()
    {
        return $this->belongsTo(TrainingCourse::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
