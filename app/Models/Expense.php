<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function expenseUploads()
    {
        return $this->hasMany(ExpenseUpload::class);
    }
    public function expenseItems()
    {
        return $this->hasMany(ExpenseItem::class);
    }
}
