<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reimbursement extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reimbursementUploads()
    {
        return $this->hasMany(ReimbursementUpload::class);
    }
    public function reimbursementItems()
    {
        return $this->hasMany(ReimbursementItem::class);
    }
    public function reimbursementMeals()
    {
        return $this->hasMany(ReimbursementMeal::class);
    }
    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
