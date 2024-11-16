<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchduleDayPattern extends Model
{
    use HasFactory;

    protected $fillable = ['time', 'schdule_day_id', 'doctor_id', 'branch_id'];

    public function doctor()
    {
        return $this->belongsTo(User::class, "doctor_id");
    }

    public function getTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('H:i'); // Adjust to your desired format
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
