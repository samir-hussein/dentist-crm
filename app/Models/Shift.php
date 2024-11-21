<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'morning_shift',
        'night_shift',
    ];

    protected $casts = [
        'morning_shift' => 'array',
        'night_shift' => 'array',
    ];
}
