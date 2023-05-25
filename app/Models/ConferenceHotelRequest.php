<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConferenceHotelRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['start_date', 'end_date'];


    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'subject_id', 'id')->where('subject_type', 'App\Models\ConferenceHotelRequest')->orderBy('created_at', 'desc');
    }
}
