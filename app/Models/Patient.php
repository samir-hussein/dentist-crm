<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date_of_birth',
        'gender',
        'phone2',
        'phone',
        'nationality',
        'need_invoice'
    ];

    // Accessor to calculate age
    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['date_of_birth'])->age;
    }
}
