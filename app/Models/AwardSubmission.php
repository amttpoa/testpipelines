<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardSubmission extends Model
{
    use HasFactory, SoftDeletes;

    public function award()
    {
        return $this->belongsTo(Award::class);
    }
}
