<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $dates = ['birthday'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeBirthDayBetween($query, Carbon $from, Carbon $till)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $till->format('m-d');
        if ($fromMonthDay <= $tillMonthDay) {
            //normal search within the one year
            $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            //we are overlapping a year, search at end and beginning of year
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }
    }
}
