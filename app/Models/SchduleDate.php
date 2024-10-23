<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchduleDate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'is_holiday', 'schdule_day_id', 'note'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'is_holiday' => 'boolean',
    ];

    public function schduleDay()
    {
        return $this->belongsTo(SchduleDay::class);
    }

    public function appointments()
    {
        return $this->hasMany(SchduleDateTime::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
