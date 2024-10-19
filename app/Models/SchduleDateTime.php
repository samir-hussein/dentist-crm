<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchduleDateTime extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time',
        'is_manually_updated',
        'is_deleted',
        'schdule_date_id',
        'patient_id',
        'manually_updated_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'datetime',
        'manually_updated_time' => 'datetime',
        'is_manually_updated' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Get the schedule date associated with the time.
     */
    public function scheduleDate()
    {
        return $this->belongsTo(SchduleDate::class);
    }

    /**
     * Get the patient associated with the time.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
