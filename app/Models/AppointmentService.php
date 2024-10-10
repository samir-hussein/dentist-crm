<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentService extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'service_id',
    ];

    // Relationships

    /**
     * Get the appointment associated with this entry.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the service associated with this entry.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
