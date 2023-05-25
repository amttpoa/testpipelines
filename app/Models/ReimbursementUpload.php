<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReimbursementUpload extends Model
{
    use HasFactory, SoftDeletes;

    public function reimbursement()
    {
        return $this->belongsTo(Reimbursement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
