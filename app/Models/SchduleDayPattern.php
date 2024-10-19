<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchduleDayPattern extends Model
{
    use HasFactory;

    protected $fillable = ['time', 'schdule_day_id'];
}
