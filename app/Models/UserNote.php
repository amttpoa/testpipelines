<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNote extends Model
{
    use HasFactory, SoftDeletes;

    public function noteUser()
    {
        return $this->belongsTo(User::class, 'id', 'note_user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
