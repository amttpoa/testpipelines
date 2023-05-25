<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UploadFile extends Model
{
    use HasFactory, SoftDeletes;

    public function uploadFolder()
    {
        return $this->belongsTo(UploadFolder::class);
    }
}
