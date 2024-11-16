<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schduleDates()
    {
        return $this->hasManyThrough(
            SchduleDate::class,  // The model you want to access through the intermediary model
            SchduleDateTime::class, // The intermediary model (pivot table)
            'branch_id', // Foreign key on the ScheduleDateTime table
            'id', // Foreign key on the ScheduleDate table
            'id', // Local key on the Branch model
            'schdule_date_id' // Local key on the ScheduleDateTime table
        );
    }

    public function doctors()
    {
        return $this->hasManyThrough(
            User::class,  // The model you want to access through the intermediary model
            SchduleDateTime::class, // The intermediary model (pivot table)
            'branch_id', // Foreign key on the ScheduleDateTime table
            'id', // Foreign key on the ScheduleDate table
            'id', // Local key on the Branch model
            'doctor_id' // Local key on the ScheduleDateTime table
        );
    }
}
