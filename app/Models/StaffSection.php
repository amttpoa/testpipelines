<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSection extends Model
{
    use HasFactory;


    public function staffs()
    {
        return $this->hasMany(Staff::class)->orderBy('order');
    }
}
