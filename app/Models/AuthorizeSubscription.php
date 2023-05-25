<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorizeSubscription extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = [
        'trial_ends_at', 'ends_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function parent()
    {
        return $this->belongsTo(AuthorizeSubscription::class, 'parent_id', 'id');
    }
    public function children()
    {
        return $this->hasMany(AuthorizeSubscription::class, 'parent_id', 'id');
    }
}
